@extends('web.custom.layouts.app')
@section('title', e($campuslife->title ?? __('Campus Life')))

@section('social_meta_tags')
    @php
        $item = $campuslife;

        $itemUrl = route('campus-life.single', ['slug' => $item->slug]);

        $itemImage = !empty($item->attach)
            ? asset('uploads/campus-life/' . $item->attach)
            : asset('dist/images/homepage/news-1.jpg');
    @endphp
@endsection

@section('content')

<section class="py-5 overflow-hidden" style="background: linear-gradient(180deg, #fff9f3 0%, #f7f9fc 100%);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="bg-white rounded-4 shadow overflow-hidden" style="border: 1px solid #f0e7dc;">

                    {{-- Banner Image --}}
                    <div class="position-relative" style="min-height: 260px;">

                        <img
                            src="{{ $itemImage }}"
                            alt="{{ $item->title }}"
                            class="img-fluid w-100"
                            style="max-height: 520px; object-fit: cover;"
                        >

                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(180deg, rgba(16,22,35,0.06) 10%, rgba(16,22,35,0.65) 100%);"></div>

                        <div class="position-absolute top-0 start-0 m-4">
                            <span class="d-inline-flex align-items-center gap-2 px-3 py-2 fw-semibold"
                                style="background: linear-gradient(135deg, #e53935 0%, #c62828 100%); color: #fff; border-radius: 999px; font-size: 0.82rem; letter-spacing: 0.02em; box-shadow: 0 8px 20px rgba(198,40,40,0.3);">
                                <i class="fa-solid fa-circle"></i>
                                Campus Life
                            </span>
                        </div>

                        <div class="position-absolute bottom-0 start-0 w-100 px-4 px-lg-5 pb-4 pb-lg-5" style="z-index: 2;">
                            <h1 class="display-5 fw-bold text-white lh-sm mb-2">
                                {{ $item->title }}
                            </h1>

                            {{-- @if(!empty($item->feature_text))
                                <p class="mb-0 text-white-50 fs-5">{{ $item->feature_text }}</p>
                            @endif --}}
                        </div>

                    </div>

                    {{-- Content Area --}}
                    <div class="p-4 p-lg-5">
                        <div class="row g-4 align-items-start">
                            <div class="col-lg-8">
                                <div class="lh-lg fs-6 text-body-secondary" style="line-height: 1.9;">
                                    {!! $item->description !!}
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="p-4 rounded-4" style="background: #fff6ef; border: 1px solid #f7e4d4;">
                                    <h5 class="fw-bold mb-3" style="color: #1d2a3a;">Quick Info</h5>

                                    @if(!empty($item->feature_text))
                                        <div class="mb-3 pb-3" style="border-bottom: 1px dashed #e9d6c3;">
                                            {{-- <div class="small text-uppercase fw-semibold" style="color: #9a6b45;">Feature Text</div> --}}
                                            <div class="mt-1 text-dark">{{ $item->feature_text }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bottom Navigation --}}
                <div class="d-flex justify-content-center mt-4">

                    <a
                        href="{{ route('campus-life') }}"
                        class="btn rounded-pill px-4 py-3 d-inline-flex align-items-center gap-2 shadow-sm"
                        style="background: #d62828; color: #fff;"
                    >
                        <i class="fa-solid fa-arrow-left"></i>
                        Back To Campus Life
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection