<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Application extends Model {
    protected $fillable = ['job_id','user_id','status','cover_letter','viewed_at'];
    protected function casts(): array { return ['viewed_at'=>'datetime']; }
    public function job(){ return $this->belongsTo(Job::class); }
    public function applicant(){ return $this->belongsTo(User::class,'user_id'); }
}