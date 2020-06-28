<?php

namespace App\Listeners;

use App\Events\AppointmentCreatedEvent;
use App\Models\AppointmentFeeType;
use App\Repositories\AppointmentFeeRepositoryInterface;
use App\Repositories\CountryRepositoryInterface;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Barryvdh\Debugbar\Facade as Debugbar;

class CreateAppointmentFeeWhenAppointmentCreated
{
    /**
     * @var AppointmentFeeRepositoryInterface
     */
    protected $appointmentFeeRepository;

    /**
     * @var CountryRepositoryInterface
     */
    protected $countryRepository;

    /**
     * CreateAppointmentFeeWhenAppointmentCreated constructor.
     * @param AppointmentFeeRepositoryInterface $appointmentFeeRepository
     * @param CountryRepositoryInterface $countryRepository
     */
    public function __construct(
        AppointmentFeeRepositoryInterface $appointmentFeeRepository,
        CountryRepositoryInterface $countryRepository
    ) {
        $this->appointmentFeeRepository = $appointmentFeeRepository;
        $this->countryRepository = $countryRepository;
    }

    /**
     * @param AppointmentCreatedEvent $event
     * @return bool
     * @throws \Exception
     */
    public function handle(AppointmentCreatedEvent $event)
    {
        /**
         * @TODO DASH1-195 Do not call appointment-backend's API anymore
         */
        $appointment = $event->getAppointment();

        $this->appointmentFeeRepository->create([
            'appointment_id' => $appointment->id,
            'booking_fee' => 0,
            'tax_amount' => 0,
            'fee_currency' => 'SGD',
            'chargebee_invoice_id' => null,
            'discount_amount' => 0
        ]);

        return true;

        /*
         * Only run this job when env is production.
         */
        if (config('app.env') != 'production') {
            return true;
        }

        $appointment = $event->getAppointment();
        $doctor = $appointment->doctor;
        $clinic = $appointment->doctorTimetable->clinic;


        $baseUrl = config('manadr.base_url_api');
        $key = config('manadr.notification_key');
        $url = $baseUrl.'/api/v1.3/dashboard/doctors/'.$doctor->id.'/clinics/'.$clinic->id.'/appointment-fees?appointment_type_id='.$appointment->appointment_type_id;

        try{
            $client = new \GuzzleHttp\Client();
            $res = $client->get($url, [
                'headers' => [
                    'Authorization' => $key,
                ],
            ]);

            $statusCode = $res->getStatusCode();

            if ($statusCode != 200) {
                throw new \Exception('Get appointment fee failed. Params encode: '.base64_encode($url));
            }

            $bodyContent = $res->getBody()->getContents();
            $jsonData = json_decode($bodyContent);

            /*
             *
             * {#428 ▼
              +"booking_fee": "5.00 SGD"
              +"booking_tax": "0.50 SGD"
              +"consulting_fee": "90,000.00 SGD"
              +"consulting_tax": "9,000.00 SGD"
              +"currency_code": "SGD"
              +"doctor_id": 1
              +"patient_condition_id": 4
              +"tax": "9,000.50 SGD"
              +"total": "99,005.50 SGD"
            }
             */

            if (!isset($jsonData->doctor_id)) {
                throw new \Exception('Get appointment fee failed. Params encode: '.base64_encode($bodyContent));
            }

            $bookingFee = $jsonData->booking_fee;
            $bookingTax = $jsonData->booking_tax;
            $consultationFee = $jsonData->consultant_fee;
            $consultationTax = $jsonData->consultant_tax;
            $discountAmount = $jsonData->discount_amount;

            $country = $this->countryRepository->getOneByCurrencyCode($jsonData->currency_code);

            if (!$country) {
                throw new \Exception('Cannot find country by currency_code');
            }

            $this->appointmentFeeRepository->create([
                'appointment_id' => $appointment->id,
                'booking_fee' => floatval($bookingFee),
                'tax_amount' => floatval($bookingTax),
                'fee_currency' => $jsonData->currency_code,
                'chargebee_invoice_id' => null,
                'discount_amount' => floatval($discountAmount)
            ]);
        } catch(\Exception $e){
            Debugbar::info('Oh!');
        }


    }

    /**
     * @param $string
     * @param $currencyCode
     * @return float
     */
    public static function convertToFloat($string, $currencyCode)
    {
		if(preg_match('/(.*?) '.$currencyCode.'/', $string, $matches)){
			$number = str_replace(',', '', $matches[1]);

			return floatval($number);
		} else {
			return 0;
		}
    }
}
