<?php
namespace App\Notifications;
use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
class NewApplicationNotification extends Notification {
    use Queueable;
    public function __construct(public Application $application) {}
    public function via(object $notifiable): array { return ['database']; }
    public function toArray(object $notifiable): array {
        return ['type'=>'new_application','application_id'=>$this->application->id,'job_id'=>$this->application->job_id,
        'job_title'=>$this->application->job->title,'applicant_name'=>$this->application->applicant->name,
        'message'=>$this->application->applicant->name.' applied for '.$this->application->job->title];
    }
}