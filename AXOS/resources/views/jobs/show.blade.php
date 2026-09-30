@extends('layouts.app')
@section('title',$job->title.' — AXOS')
@section('content')
<div class="container">
    <div class="card">
        <span class="badge">{{str_replace('_',' ',ucfirst($job->employment_type))}}</span>
        <h1>{{$job->title}}</h1>
        <p class="muted">
            {{$job->employerProfile?->company_name ?? $job->employer->name}}
            · {{$job->location ?: 'Location not specified'}}
            @if($job->remote) · Remote @endif
        </p>

        @if($job->salary_min || $job->salary_max)
            <p><strong>Salary:</strong>
                {{ $job->currency }}
                {{ $job->salary_min ? number_format($job->salary_min) : '' }}
                @if($job->salary_min && $job->salary_max) — @endif
                {{ $job->salary_max ? number_format($job->salary_max) : '' }}
            </p>
        @endif

        <hr style="border-color:#282e3a">

        <h2>About the role</h2>
        <p style="white-space:pre-line">{{$job->description}}</p>

        @foreach(['requirements'=>'Requirements','responsibilities'=>'Responsibilities','benefits'=>'Benefits'] as $key=>$label)
            @if($job->$key)
                <h2>{{$label}}</h2>
                <p style="white-space:pre-line">{{$job->$key}}</p>
            @endif
        @endforeach

        @auth
            @if(auth()->user()->isJobSeeker())
                <form method="POST" action="{{route('applications.store',$job)}}" class="card" style="margin-top:25px">
                    @csrf
                    <h2>Apply for this job</h2>
                    <textarea class="textarea" name="cover_letter" rows="7" maxlength="5000" placeholder="Optional cover letter"></textarea>
                    <br><br>
                    <button class="btn">Submit Application</button>
                </form>
            @endif
        @else
            <p><a class="btn" href="{{route('login')}}">Login to apply</a></p>
        @endauth
    </div>
</div>

<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'JobPosting',
    'title' => $job->title,
    'description' => strip_tags($job->description),
    'datePosted' => optional($job->published_at)->toDateString(),
    'validThrough' => optional($job->expires_at)->toDateString(),
    'employmentType' => strtoupper($job->employment_type),
    'hiringOrganization' => [
        '@type' => 'Organization',
        'name' => $job->employerProfile?->company_name ?? $job->employer->name,
    ],
    'jobLocation' => [
        '@type' => 'Place',
        'address' => [
            '@type' => 'PostalAddress',
            'addressLocality' => $job->location ?: 'Remote',
        ],
    ],
], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}
</script>
@endsection
