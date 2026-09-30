<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Job extends Model {
    protected $fillable = ['user_id','employer_profile_id','title','category','employment_type','location','remote','salary_min','salary_max','currency','description','requirements','responsibilities','benefits','status','published_at','expires_at'];
    protected function casts(): array { return ['remote'=>'boolean','published_at'=>'datetime','expires_at'=>'datetime','salary_min'=>'decimal:2','salary_max'=>'decimal:2']; }
    public function employer(){ return $this->belongsTo(User::class,'user_id'); }
    public function employerProfile(){ return $this->belongsTo(EmployerProfile::class); }
    public function applications(){ return $this->hasMany(Application::class); }
    public function isPublished(){ return $this->status === 'published'; }
}