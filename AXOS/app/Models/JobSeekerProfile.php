<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class JobSeekerProfile extends Model {
    protected $fillable = ['user_id','headline','bio','phone','location','skills','experience','education','resume_path'];
    public function user(){ return $this->belongsTo(User::class); }
}