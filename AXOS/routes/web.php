<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController,JobController,ApplicationController,JobSeekerDashboardController,EmployerDashboardController,AdminDashboardController,ProfileController,NotificationController};

Route::get('/', fn()=>view('home'))->name('home');
Route::get('/health', fn()=>response()->json([
    'status'=>'ok',
    'application'=>'AXOS',
    'timestamp'=>now()->toISOString()
]))->name('health');

Route::get('/sitemap.xml', function () {
    $jobs = \App\Models\Job::query()
        ->where('status', 'published')
        ->latest('published_at')
        ->get();

    return response()
        ->view('sitemap', compact('jobs'))
        ->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::get('/login',[AuthController::class,'showLogin'])->middleware('guest')->name('login');
Route::post('/login',[AuthController::class,'login'])->middleware('guest');
Route::get('/register',[AuthController::class,'showRegister'])->middleware('guest')->name('register');
Route::post('/register',[AuthController::class,'register'])->middleware('guest');
Route::post('/logout',[AuthController::class,'logout'])->middleware('auth')->name('logout');

Route::get('/jobs',[JobController::class,'index'])->name('jobs.index');
Route::get('/jobs/{job}',[JobController::class,'show'])->name('jobs.show');

Route::middleware(['auth'])->group(function(){
 Route::post('/jobs/{job}/apply',[ApplicationController::class,'store'])->middleware(['role:job_seeker','throttle:10,1'])->name('applications.store');
 Route::get('/applications',[ApplicationController::class,'index'])->middleware('role:job_seeker')->name('applications.index');
 Route::get('/applications/{application}',[ApplicationController::class,'show'])->name('applications.show');
 Route::get('/applications/{application}/resume',[ApplicationController::class,'resume'])->middleware('role:employer')->name('applications.resume');
 Route::get('/notifications',[NotificationController::class,'index'])->name('notifications.index');
 Route::get('/notifications/unread',[NotificationController::class,'unread'])->name('notifications.unread');
 Route::patch('/notifications/{notification}/read',[NotificationController::class,'read'])->name('notifications.read');
 Route::patch('/notifications/read-all',[NotificationController::class,'all'])->name('notifications.all');
});

Route::middleware(['auth','role:job_seeker'])->prefix('job-seeker')->name('job-seeker.')->group(function(){
 Route::get('/dashboard',[JobSeekerDashboardController::class,'index'])->name('dashboard');
 Route::get('/profile',[ProfileController::class,'seeker'])->name('profile.edit');
 Route::put('/profile',[ProfileController::class,'seekerUpdate'])->name('profile.update');
 Route::post('/profile/resume',[ProfileController::class,'resume'])->name('profile.resume');
});
Route::middleware(['auth','role:employer'])->prefix('employer')->name('employer.')->group(function(){
 Route::get('/dashboard',[EmployerDashboardController::class,'index'])->name('dashboard');
 Route::get('/profile',[ProfileController::class,'employer'])->name('profile.edit');
 Route::put('/profile',[ProfileController::class,'employerUpdate'])->name('profile.update');
 Route::post('/profile/logo',[ProfileController::class,'logo'])->name('profile.logo');
 Route::get('/jobs',[JobController::class,'employerIndex'])->name('jobs.index');
 Route::get('/jobs/create',[JobController::class,'create'])->name('jobs.create');
 Route::post('/jobs',[JobController::class,'store'])->name('jobs.store');
 Route::get('/jobs/{job}/edit',[JobController::class,'edit'])->name('jobs.edit');
 Route::put('/jobs/{job}',[JobController::class,'update'])->name('jobs.update');
 Route::patch('/jobs/{job}/close',[JobController::class,'close'])->name('jobs.close');
 Route::delete('/jobs/{job}',[JobController::class,'destroy'])->name('jobs.destroy');
 Route::get('/jobs/{job}/applications',[ApplicationController::class,'employerIndex'])->name('applications.index');
 Route::patch('/applications/{application}/status',[ApplicationController::class,'updateStatus'])->name('applications.status');
});
Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function(){
 Route::get('/dashboard',[AdminDashboardController::class,'index'])->name('dashboard');
});
