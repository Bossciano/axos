<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller {
 public function showLogin(){ return view('auth.login'); }
 public function login(Request $r){ $data=$r->validate(['email'=>'required|email','password'=>'required|string']);
   if(!Auth::attempt($data,$r->boolean('remember'))){ return back()->withErrors(['email'=>'Invalid credentials.'])->onlyInput('email'); }
   $r->session()->regenerate(); return redirect()->intended($this->dashboard(Auth::user())); }
 public function showRegister(){ return view('auth.register'); }
 public function register(Request $r){ $d=$r->validate(['name'=>'required|string|max:120','email'=>'required|email|max:255|unique:users,email','password'=>'required|string|min:8|confirmed','role'=>'required|in:employer,job_seeker']);
   $u=User::create(['name'=>$d['name'],'email'=>$d['email'],'password'=>Hash::make($d['password'])]); $u->role=$d['role']; $u->save(); Auth::login($u);
   return redirect($this->dashboard($u)); }
 public function logout(Request $r){ Auth::logout(); $r->session()->invalidate(); $r->session()->regenerateToken(); return redirect('/'); }
 private function dashboard($u){ return $u->role==='employer'?route('employer.dashboard'):($u->role==='admin'?route('admin.dashboard'):route('job-seeker.dashboard')); }
}