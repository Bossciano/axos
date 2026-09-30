@extends('layouts.app')
@section('title','AXOS — Find opportunities')
@section('content')
<div class="container">
    <div style="max-width:800px;padding:55px 0 35px">
        <div class="badge">AXOS JOB PLATFORM</div>
        <h1 style="font-size:clamp(42px,7vw,78px);line-height:1.02;margin:18px 0">
            Find the right opportunity. Build what comes next.
        </h1>
        <p class="muted" style="font-size:18px">
            AXOS connects employers with job seekers through a simple, focused hiring workflow.
        </p>

        <form action="{{route('jobs.index')}}" style="margin-top:28px" class="card">
            <div class="grid">
                <input class="input" name="search" placeholder="Job title or keyword">
                <input class="input" name="location" placeholder="Location">
            </div>
            <br>
            <button class="btn">Search jobs</button>
        </form>
    </div>

    <div style="padding:35px 0">
        <h2>How AXOS works</h2>
        <div class="grid">
            <div class="card"><h3>1. Discover</h3><p class="muted">Search jobs by role, location, category and work arrangement.</p></div>
            <div class="card"><h3>2. Apply</h3><p class="muted">Create your profile and apply directly to relevant opportunities.</p></div>
            <div class="card"><h3>3. Connect</h3><p class="muted">Employers review applicants and update application status.</p></div>
        </div>
    </div>

    <div style="padding:35px 0">
        <div class="card">
            <h2>For employers</h2>
            <p class="muted">Create your company profile, publish jobs and manage applicants from one dashboard.</p>
            <a class="btn" href="{{route('register')}}">Create Employer Account</a>
        </div>
    </div>
</div>
@endsection
