<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/') }}</loc>
    </url>
    <url>
        <loc>{{ route('jobs.index') }}</loc>
    </url>
    @foreach($jobs as $job)
        <url>
            <loc>{{ route('jobs.show', $job) }}</loc>
            @if($job->updated_at)
                <lastmod>{{ $job->updated_at->toAtomString() }}</lastmod>
            @endif
        </url>
    @endforeach
</urlset>
