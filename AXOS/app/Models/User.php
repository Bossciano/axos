<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class User extends Authenticatable {
    use HasFactory, Notifiable;
    protected $fillable = ['name','email','password'];
    protected $hidden = ['password','remember_token'];
    protected function casts(): array { return ['email_verified_at'=>'datetime','password'=>'hashed']; }
    public function employerProfile(){ return $this->hasOne(EmployerProfile::class); }
    public function jobSeekerProfile(){ return $this->hasOne(JobSeekerProfile::class); }
    public function jobs(){ return $this->hasMany(Job::class); }
    public function applications(){ return $this->hasMany(Application::class); }
    public function isEmployer(){ return $this->role === 'employer'; }
    public function isJobSeeker(){ return $this->role === 'job_seeker'; }
}