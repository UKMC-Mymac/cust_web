@extends('web.custom.layouts.app')
@section('title', $member->name)

@section('content')
<section class="py-5" style="background: #f2f6fa;">
    <div class="container" style="max-width: 1200px;">
        <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
            <div style="height: 4px; background: linear-gradient(90deg, #125875 0%, #1b8aad 60%, #c8973a 100%);"></div>
            <div class="card-body p-4 p-md-5">
                {{-- <a href="{{ route('members') }}" class="btn btn-outline-secondary btn-sm mb-4">Back to Members</a> --}}

                <h1 class="mb-1" style="font-weight: 800; color: #0f3a4f;">{{ $member->name }}</h1>
                @if(!empty($member->designation))
                    <p class="text-muted mb-4">{{ $member->designation }}</p>
                @endif

                <div class="member-rich-content">
                    {!! $member->description !!}
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.member-rich-content {
    color: #2c4a5a;
    font-size: 1.03rem;
    line-height: 1.85;
}
.member-rich-content > *:first-child { margin-top: 0 !important; }
.member-rich-content > *:last-child { margin-bottom: 0 !important; }
.member-rich-content h1,
.member-rich-content h2 {
    color: #0f3a4f;
    font-weight: 800;
    margin: 1.6rem 0 0.6rem;
}
.member-rich-content h3,
.member-rich-content h4,
.member-rich-content h5,
.member-rich-content h6 {
    color: #125875;
    font-weight: 700;
    margin: 1.25rem 0 0.5rem;
}
.member-rich-content img {
    max-width: 100%;
    height: auto;
    border-radius: 12px;
    box-shadow: 0 10px 24px rgba(13,43,62,0.12);
    margin: 1rem 0;
}
.member-rich-content .member-card-embed {
    width: 100%;
    max-width: 320px;
    border-collapse: separate;
    border-spacing: 0;
    margin: 1rem 0;
    border: 1px solid rgba(18, 88, 117, 0.14);
    border-radius: 16px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 10px 24px rgba(13,43,62,0.08);
}
.member-rich-content .member-card-embed img {
    width: 100%;
    aspect-ratio: 1 / 1;
    object-fit: cover;
    object-position: center;
    display: block;
    box-shadow: none;
    margin: 0;
}
.member-rich-content .member-card-link {
    color: #0f3a4f;
    text-decoration: none;
}
.member-rich-content .member-card-link:hover {
    text-decoration: underline;
}
.member-rich-content table {
    width: 100%;
    border-collapse: collapse;
    margin: 1rem 0;
}
.member-rich-content td,
.member-rich-content th {
    border: 1px solid rgba(18, 88, 117, 0.12);
    padding: 0.65rem 0.8rem;
}
</style>
@endsection
