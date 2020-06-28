<?php

namespace App\Console\Commands;

use App\Jobs\SendNotificationToUser;
use App\Models\Appointment;
use App\Repositories\AppointmentRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class SendNotificationToUserCommand extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manadr:send-notification-to-user {appointmentId} {message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification to user';

    /**
     * SendNotificationToUserCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param AppointmentRepositoryInterface $appointmentRepository
     * @return bool
     */
    public function handle(AppointmentRepositoryInterface $appointmentRepository)
    {
        $appointmentId = $this->argument('appointmentId');
        $message = $this->argument('message');

        /** @var Appointment $appointment */
        if (!$appointment = $appointmentRepository->find($appointmentId)) {
            $this->error('Appointment Not Found.');

            return false;
        }

        $result = $this->dispatchNow(new SendNotificationToUser(
            $appointment,
            $message
        ));

        if (config('queue.default') == 'sync') {
            $this->info('Run command with sync mode. Result: '.$result);
        } else {
            $this->info('Push Appointment #'.$appointment->id.' to queues.');
        }

        return true;
    }
}
