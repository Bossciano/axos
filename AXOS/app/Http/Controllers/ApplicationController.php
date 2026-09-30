<?php
namespace App\Http\Controllers;
use App\Models\{Application,Job};
use App\Notifications\{NewApplicationNotification,ApplicationStatusNotification};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ApplicationController extends Controller {
 public function store(Request $r,Job $job){ abort_unless($job->status==='published',404); if($job->expires_at&&now()->greaterThan($job->expires_at)) return back()->withErrors(['job'=>'This job application period has ended.']);
   abort_unless($r->user()->isJobSeeker(),403); abort_unless($r->user()->jobSeekerProfile?->exists ?? false,403);
   $r->validate(['cover_letter'=>'nullable|string|max:5000']); if(Application::where(['job_id'=>$job->id,'user_id'=>$r->user()->id])->exists()) return back()->withErrors(['job'=>'You already applied for this job.']);
   $a=Application::create(['job_id'=>$job->id,'user_id'=>$r->user()->id,'cover_letter'=>$r->cover_letter,'status'=>'pending']); $job->employer->notify(new NewApplicationNotification($a->load(['job','applicant']))); return back()->with('success','Application submitted.');
 }
 public function index(Request $r){ $applications=$r->user()->applications()->with('job')->latest()->paginate(15); return view('applications.index',compact('applications')); }
 public function employerIndex(Request $r,Job $job){ abort_unless($job->user_id===$r->user()->id,403); $applications=$job->applications()->with('applicant.jobSeekerProfile')->latest()->paginate(15); return view('employer.applications.index',compact('job','applications')); }
 public function show(Request $r,Application $application){ abort_unless($application->user_id===$r->user()->id||$application->job->user_id===$r->user()->id,403); $application->load(['job.employerProfile','applicant.jobSeekerProfile']); if($application->job->user_id===$r->user()->id&&$application->status==='pending'){ $application->update(['status'=>'viewed','viewed_at'=>now()]); $application->applicant->notify(new ApplicationStatusNotification($application->fresh(),'viewed')); } return view('applications.show',compact('application')); }
 public function updateStatus(Request $r,Application $application){ abort_unless($application->job->user_id===$r->user()->id,403); $d=$r->validate(['status'=>'required|in:viewed,shortlisted,rejected,hired']); $old=$application->status; $application->update($d); if($old!==$d['status']) $application->applicant->notify(new ApplicationStatusNotification($application->fresh(),' '.$d['status'])); return back()->with('success','Application status updated.'); }
 public function resume(Request $r,Application $application){ abort_unless($application->job->user_id===$r->user()->id,403); $path=$application->applicant->jobSeekerProfile?->resume_path; abort_unless($path&&Storage::disk('private')->exists($path),404); return Storage::disk('private')->download($path); }
}