<?php
namespace App\Repositories\Eloquent;
use App\Repositories\PatientRepositoryInterface;
use App\Models\Patient;
use App\Services\AdminUserServiceInterface;
use App\Services\DoctorServiceInterface;
use Illuminate\Database\Eloquent\Builder;

class PatientRepository extends SingleKeyModelRepository implements PatientRepositoryInterface
{
    public function __construct(
        DoctorServiceInterface $doctorService,
        AdminUserServiceInterface $adminUserService
    )
    {
        $this->doctorService = $doctorService;
        $this->adminUserService = $adminUserService;
    }
    public function getBlankModel()
    {
        return new Patient();
    }
    public function rules()
    {
        return [
        ];
    }
    public function messages()
    {
        return [
        ];
    }
    /**
     * @inheritdoc
     */
    public function searchByIcOrName($text, $excludingDeceased = true, $searchContext = 'doctor')
    {
//        $textArray = explode(' ', $text);
//        $textArray = array_map(function($word){
//            if(strpos($word,'+') === false && strpos($word, '-') === false){
//                $word = '+' . $word . '*';
//            }
//            return $word;
//        }, $textArray);
//        $text = implode(' ', $textArray);
//
//        unset($textArray);
        $query = $this->getBlankModel()->where(function (Builder $query) use ($text, $excludingDeceased, $searchContext) {
            $text.= '*';
            $query->whereRaw(
                "MATCH(first_name, last_name, email, id_number, alias, imported_name, imported_email) AGAINST(? IN BOOLEAN MODE)",
                array($text)
            );
            if($excludingDeceased){
                $query->where('deceased', 0);
            }
            switch($searchContext){
                case 'doctor': //doctor, will see linked clinic's patients & the ones who booked appointment only
                    abort_unless($currentDoctor = $this->doctorService->getUser()->account, 500, 'Your session has been expired. Please login again.');
                    abort_unless($currentClinics = $currentDoctor->clinics, 500, 'You haven\'t been connected to any clinics');
                    $currentClinicIds = $currentClinics->pluck('id')->toArray();
                    $query->where(function(Builder $query) use ($currentClinicIds, $currentDoctor){
                        $query->whereHas('clinics', function($query) use ($currentClinicIds){
                            return $query->whereIn('clinic_id', $currentClinicIds);
                        })
                            ->orWhereHas('appointments', function($query) use ($currentDoctor){
                                return $query->where('doctor_id', $currentDoctor->id);
                            })
                        ;
                    });
                    break;
                case 'superAdmin':
                case 'createAppointment':
                    break;
                case 'clinicOwner':
                    abort_unless($currentAdminUser = $this->adminUserService->getUser(), 500, 'Your session has been expired. Please login again.');
                    abort_unless($currentClinics = $currentAdminUser->clinics, 500, 'You haven\'t been connected to any clinics');
                    $currentClinicIds = $currentClinics->pluck('id')->toArray();
                    $query->where(function(Builder $query) use ($currentClinicIds, $currentAdminUser){
                        $query->whereHas('clinics', function($query) use ($currentClinicIds){
                            return $query->whereIn('clinic_id', $currentClinicIds);
                        });
                    });
                    break;
            }
        });
        $patients = $query->get();
        $patients->load('profileImage', 'country', 'account', 'user');
        return $patients;
    }
}