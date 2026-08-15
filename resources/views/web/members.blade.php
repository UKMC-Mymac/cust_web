@extends('web.custom.layouts.app')
@section('title', 'Members')

@section('content')
<style>
    .member-card-image {
        width: 100%;
        aspect-ratio: 1 / 1;
        object-fit: cover;
        object-position: center;
        display: block;
    }
</style>

<section class="py-5" style="background: #f3f7fb;">
    <div class="container">
        <div class="row g-3 g-lg-4">
            @forelse($members as $item)
                @php
                    preg_match('/<img[^>]+src=["\']?([^"\' >]+)["\']?/i', (string) ($item->description ?? ''), $imageMatch);
                    $cardImage = $imageMatch[1] ?? asset('dist/images/shape/shape-2.png');
                @endphp

                <div class="col-6 col-md-4 col-lg-2">
                    <article class="card h-100 border-0 shadow-sm overflow-hidden" style="border-radius: 14px;">
                        <a href="{{ route('members.single', $item->slug) }}" class="d-block">
                            <img src="{{ $cardImage }}" alt="{{ $item->name }}" class="member-card-image">
                        </a>

                        <div class="card-body p-3 d-flex flex-column">
                            <h3 class="h6 mb-2" style="line-height:1.35;">
                                <a href="{{ route('members.single', $item->slug) }}" class="text-decoration-none text-dark fw-bold">{{ $item->name }}</a>
                            </h3>

                            @if(!empty($item->designation))
                                <p class="text-muted small mb-2">{{ $item->designation }}</p>
                            @endif
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-light border text-center mb-0">
                        No members found.
                    </div>
                </div>
            @endforelse
        </div>

        <div class="row mt-4">
            <div class="col-12 d-flex justify-content-center">
                {{ $members->links() }}
            </div>
        </div>
    </div>
</section>
@endsection