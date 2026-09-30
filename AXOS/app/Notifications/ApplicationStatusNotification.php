<?php
namespace App\Notifications;
use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
class ApplicationStatusNotification extends Notification {
    use Queueable;
    public function __construct(public Application $application, public string $status) {}
    public function via(object $notifiable): array { return ['database']; }
    public function toArray(object $notifiable): array {
        $messages=['viewed'=>'Your application was viewed by the employer.','shortlisted'=>'Your application has been shortlisted.',
        'rejected'=>'Your application was not selected.','hired'=>'Congratulations! Your application has been marked as hired.'];
        return ['type'=>'application_status','application_id'=>$this->application->id,'job_id'=>$this->application->job_id,
        'job_title'=>$this->application->job->title,'status'=>$this->status,
        'message'=>$messages[$this->status] ?? 'Your application status was updated.'];
    }
}