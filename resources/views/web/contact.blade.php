@extends('web.custom.layouts.app')
@section('title','Contact Us')
@section('content')

<section class="py-5 bg-light">
    <div class="container">

        @if(!empty($contact))

            <div class="row g-5">

                <!-- Contact Information -->
                <div class="col-lg-6">

                    <div class="bg-white rounded-4 shadow-sm p-5 h-100">

                        <!-- Title -->
                        <h2 class="fw-bold text-dark mb-4">
                            {{ $contact->title }}
                        </h2>

                        @if(!empty($contact->subtitle))
                            <p class="text-muted mb-4">
                                {{ $contact->subtitle }}
                            </p>
                        @endif

                        <!-- Contact Details -->
                        <div class="d-flex flex-column gap-4">

                            <!-- Email -->
                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-danger-subtle rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                     style="width: 50px; height: 50px;">
                                    <i class="fa-solid fa-envelope text-danger"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold text-dark mb-1">{{ __('Email') }}</h6>
                                    <a href="mailto:{{ $contact->email }}" class="text-danger text-decoration-none">
                                        {{ $contact->email }}
                                    </a>
                                </div>
                            </div>

                            <!-- Phone -->
                            @if(!empty($contact->phone))
                                <div class="d-flex align-items-start gap-3">
                                    <div class="bg-danger-subtle rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                         style="width: 50px; height: 50px;">
                                        <i class="fa-solid fa-phone text-danger"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold text-dark mb-1">{{ __('Phone') }}</h6>
                                        <a href="tel:{{ $contact->phone }}" class="text-danger text-decoration-none">
                                            {{ $contact->phone }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                           
                                <!-- Website -->
                            @if(!empty($contact->website))
                                <div class="d-flex align-items-start gap-3">
                                    <div class="bg-danger-subtle rounded-circle d-flex align-items-center justify-content-center    flex-shrink-0"
                                         style="width: 50px; height: 50px;">
                                        <i class="fa-solid fa-globe text-danger"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold text-dark mb-1">{{ __('Website') }}</h6>
                                        <a href="{{ $contact->website }}" target="_blank" rel="noopener" class="text-danger text-decoration-none">
                                            {{ $contact->website }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <!-- Address -->
                            @if(!empty($contact->address))
                                <div class="d-flex align-items-start gap-3">
                                    <div class="bg-danger-subtle rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                                         style="width: 50px; height: 50px;">
                                        <i class="fa-solid fa-location-dot text-danger"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-semibold text-dark mb-1">{{ __('Address') }}</h6>
                                        <p class="text-muted mb-0">
                                            {{ $contact->address }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                        </div>

                    </div>

                </div>

                  <div class="col-lg-6 mx-auto">

                    <div class="bg-white rounded-4 shadow-sm p-5">

                        @include('web.student.inc.message')

                        <h3 class="fw-bold text-dark mb-4">
                            {{ __('Send us a Message') }}
                        </h3>

                        <form method="POST" action="{{ route('contact.store') }}" class="needs-validation" novalidate>
                            @csrf

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <label for="name" class="form-label fw-semibold">{{ __('Full Name') }} <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">{{ __('Email') }} <span class="text-danger">*</span></label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- <div class="col-md-12">
                                    <label for="subject" class="form-label fw-semibold">{{ __('Subject') }} <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('subject') is-invalid @enderror" 
                                           id="subject" 
                                           name="subject" 
                                           value="{{ old('subject') }}" 
                                           required>
                                    @error('subject')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div> --}}
                                @php
                                $subjects = [
                                    'General Inquiry',
                                    'Technical Support',
                                    'Website Issue',
                                    'Admission Information',
                                    'Academic Information',
                                    'Complaint',
                                    'Feedback',
                                    'Other',
                                ];
                                @endphp

                                <select class="form-select @error('subject') is-invalid @enderror"
                                        id="subject"
                                        name="subject"
                                        required>
                                    <option value="">Select a Subject</option>

                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject }}"
                                            {{ old('subject') == $subject ? 'selected' : '' }}>
                                            {{ $subject }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="col-md-12">
                                    <label for="phone" class="form-label fw-semibold">{{ __('Phone') }}</label>
                                    <input type="tel" 
                                           class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="message" class="form-label fw-semibold">{{ __('Message') }} <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" 
                                              id="message" 
                                              name="message" 
                                              rows="5" 
                                              required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-danger btn-lg w-100">
                                        <i class="fa-solid fa-paper-plane me-2"></i>
                                        {{ __('Send Message') }}
                                    </button>
                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>
           @isset($contact->description)
                  <div class="row mt-5">

                    <div class="col-12 bg-white rounded-4 shadow-sm p-5">
                        @php
                                $content = $contact->description;
                                if (!empty($content)) {
                                    $content = preg_replace_callback(
                                        '/(src\s*=\s*)(["\']?)(.*?)uploads\/([^"\'>\s]+)(["\']?)/i',
                                        function ($m) {
                                            return $m[1] . '"' . asset('uploads/' . $m[4]) . '"';
                                        },
                                        $content
                                    );
                                }
                            @endphp
                            {!! $content !!}
                    </div>

            </div>
           @endisset
         


            <!-- Contact Form -->
            <div class="row mt-5">

                <!-- Map or Additional Info -->
                <div class="col-lg-12">

                    @if(!empty($contact->map_link))
                        <div class="bg-white rounded-4 shadow-sm overflow-hidden h-100">
                            <iframe src="{{ $contact->map_link }}" 
                                    width="100%" 
                                    height="500" 
                                    style="border:0; border-radius: 1rem;" 
                                    allowfullscreen="" 
                                    loading="lazy" 
                                    referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    @else
                        <div class="bg-white rounded-4 shadow-sm p-5 h-100 d-flex align-items-center justify-content-center text-center">
                            <div>
                                <i class="fa-solid fa-map fa-4x text-muted mb-3 d-block"></i>
                                <h5 class="text-muted">{{ __('Map Location') }}</h5>
                                <p class="text-muted small">Map will be displayed when available.</p>
                            </div>
                        </div>
                    @endif

                </div>

            </div>

        @else

            <div class="row">
                <div class="col-12">
                    <div class="alert alert-light border text-center py-5">
                        <i class="fa-solid fa-inbox fa-3x text-muted mb-3 d-block"></i>
                        <h5 class="text-muted mb-2">{{ __('No contact information available.') }}</h5>
                        <p class="text-muted mb-0">Please try again later.</p>
                    </div>
                </div>
            </div>

        @endif

    </div>
</section>

<style>
    .contact-description {
        font-size: 1.0625rem;
        color: #555;
    }

    .contact-description h1,
    .contact-description h2,
    .contact-description h3,
    .contact-description h4,
    .contact-description h5,
    .contact-description h6 {
        font-weight: 600;
        color: #222;
        margin-top: 1rem;
        margin-bottom: 0.75rem;
    }

    .contact-description p {
        margin-bottom: 1rem;
    }

    .contact-description a {
        color: #dc3545;
        text-decoration: none;
    }

    .contact-description a:hover {
        text-decoration: underline;
    }
</style>

@endsection
