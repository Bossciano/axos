<?php
namespace App\Http\Controllers;
use App\Models\Job;
use Illuminate\Http\Request;
class JobController extends Controller {
 public function index(Request $r){ $q=Job::with('employerProfile')->where('status','published')->when($r->search,fn($x,$v)=>$x->where(fn($y)=>$y->where('title','like',"%$v%")->orWhere('description','like',"%$v%")))->when($r->location,fn($x,$v)=>$x->where('location','like',"%$v%"))->when($r->category,fn($x,$v)=>$x->where('category',$v))->when($r->employment_type,fn($x,$v)=>$x->where('employment_type',$v))->when($r->boolean('remote'),fn($x)=>$x->where('remote',true))->latest('published_at')->paginate(12)->withQueryString(); return view('jobs.index',compact('q')); }
 public function show(Job $job){ abort_unless($job->status==='published',404); return view('jobs.show',compact('job')); }
 public function employerIndex(Request $r){ $jobs=$r->user()->jobs()->latest()->paginate(15); return view('employer.jobs.index',compact('jobs')); }
 public function create(){ return view('employer.jobs.create'); }
 public function store(Request $r){ $d=$this->validateJob($r); $p=$r->user()->employerProfile ?: $r->user()->employerProfile()->create(['company_name'=>$r->user()->name]); $d['user_id']=$r->user()->id;$d['employer_profile_id']=$p->id;$d['status']='published';$d['published_at']=now(); Job::create($d); return redirect()->route('employer.jobs.index')->with('success','Job published.'); }
 public function edit(Job $job){ abort_unless($job->user_id===request()->user()->id,403); return view('employer.jobs.edit',compact('job')); }
 public function update(Request $r,Job $job){ abort_unless($job->user_id===$r->user()->id,403); $job->update($this->validateJob($r)); return redirect()->route('employer.jobs.index')->with('success','Job updated.'); }
 public function close(Job $job){ abort_unless($job->user_id===request()->user()->id,403); $job->update(['status'=>'closed']); return back()->with('success','Job closed.'); }
 public function destroy(Job $job){ abort_unless($job->user_id===request()->user()->id,403); $job->delete(); return back()->with('success','Job deleted.'); }
 private function validateJob(Request $r){ return $r->validate(['title'=>'required|string|max:150','category'=>'nullable|string|max:100','employment_type'=>'required|in:full_time,part_time,contract,internship,temporary','location'=>'nullable|string|max:150','remote'=>'boolean','salary_min'=>'nullable|numeric|min:0','salary_max'=>'nullable|numeric|gte:salary_min','currency'=>'nullable|string|max:10','description'=>'required|string|max:10000','requirements'=>'nullable|string|max:10000','responsibilities'=>'nullable|string|max:10000','benefits'=>'nullable|string|max:10000','expires_at'=>'nullable|date|after_or_equal:today']); }
}