@extends('web.custom.layouts.app')
@section('title', __('navbar_notice'))

@section('content')

<section class="py-5 bg-light">
    <div class="container">
    
        <!-- Page Header -->
        <div class="row mb-4 align-items-center">
            <div class="col-lg-6">

                <div class="d-flex align-items-center mb-2">
                    <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center me-3"
                         style="width: 42px; height: 42px;">
                        <i class="fa-solid fa-bell text-white"></i>
                    </div>

                    <div>
                        <h3 class="fw-bold mb-0">
                            {{ __('University Notices') }}
                        </h3>

                        <small class="text-muted">
                            {{ __('Latest announcements and updates') }}
                        </small>
                    </div>
                </div>

            </div>

            <div class="col-lg-6">

                <form method="GET" action="{{ route('notice') }}">

                    <div class="d-flex justify-content-lg-end gap-2">

                        <select class="form-select"
                                name="category"
                                onchange="this.form.submit()"
                                style="max-width: 260px;">

                            <option value="">
                                {{ __('All Categories') }}
                            </option>

                            @forelse($categories as $category)
                                <option value="{{ $category->slug }}"
                                    @if($selected_category == $category->slug) selected @endif>
                                    {{ $category->title }}
                                </option>
                            @empty
                            @endforelse

                        </select>

                        @if($selected_category)
                            <a href="{{ route('notice') }}"
                               class="btn btn-outline-secondary">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        @endif

                    </div>

                </form>

            </div>
        </div>

        <!-- Notice List -->
        <div class="bg-white rounded-3 shadow-sm overflow-hidden border">

            @forelse($notices as $notice)

                @php
                    $itemRoute = route('notice.show', ['notice' => $notice->id]);

                    $dayDiff = \Carbon\Carbon::parse($notice->date)
                        ->diffInDays(\Carbon\Carbon::today(), false);

                    $isNew = $dayDiff >= 0 && $dayDiff <= 7;

                    $categoryBadge = $notice->category->title ?? __('Notice');
                @endphp

                <a href="{{ $itemRoute }}"
                   class="text-decoration-none text-dark">

                    <div class="p-4 border-bottom">

                        <div class="row align-items-center g-3">

                            <!-- Date -->
                            <div class="col-auto">

                                <div class="text-center bg-light rounded-3 px-3 py-2 border"
                                     style="min-width: 72px;">

                                    <div class="fw-bold text-danger fs-4 lh-1">
                                        {{ \Carbon\Carbon::parse($notice->date)->format('d') }}
                                    </div>

                                    <small class="text-muted text-uppercase">
                                        {{ \Carbon\Carbon::parse($notice->date)->format('M Y') }}
                                    </small>

                                </div>

                            </div>

                            <!-- Content -->
                            <div class="col">

                                <div class="d-flex align-items-center gap-2 flex-wrap mb-2">

                                    @if($notice->categories->isNotEmpty())
                                        @foreach($notice->categories as $cat)
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                                {{ $cat->title }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                            {{ $categoryBadge }}
                                        </span>
                                    @endif

                                    @if($isNew)
                                        <span class="badge bg-success">
                                            {{ __('NEW') }}
                                        </span>
                                    @endif

                                </div>

                                <h5 class="fw-semibold mb-1">
                                    {{ $notice->title }}
                                </h5>

                                <small class="text-muted">
                                    <i class="fa-regular fa-calendar me-1"></i>
                                    {{ \Carbon\Carbon::parse($notice->date)->format('l, d F Y') }}
                                </small>

                            </div>

                            <!-- Action -->
                            <div class="col-auto">

                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                     style="width: 38px; height: 38px;">

                                    <i class="fa-solid fa-arrow-right text-muted small"></i>

                                </div>

                            </div>

                        </div>

                    </div>

                </a>

            @empty

                <div class="text-center py-5">

                    <div class="mb-3">
                        <i class="fa-solid fa-folder-open fa-3x text-muted"></i>
                    </div>

                    <h5 class="fw-bold mb-2">
                        {{ __('No Notices Available') }}
                    </h5>

                    <p class="text-muted mb-0">
                        {{ __('There are no notices published right now.') }}
                    </p>

                </div>

            @endforelse

        </div>

        <!-- Pagination -->
        @if($notices->count() > 0 || $notices->total() > 0)

            <div class="d-flex justify-content-center mt-4">
                {{ $notices->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>

        @endif

    </div>
</section>

@endsection