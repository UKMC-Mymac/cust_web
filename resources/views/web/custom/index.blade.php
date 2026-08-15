@extends('web.custom.layouts.app')

@section('title', 'Home')

@section('meta_description', 'Central University of Science and Technology - A modern institution committed to transforming knowledge into employability and shaping the leaders of tomorrow.')

@section('meta_keywords', 'CUST, University, Education, Admission, Programs, Academics')

@section('content')
    @if(!isset($setting->web_sections['hero']) || $setting->web_sections['hero'] == 1)
        @include('web.custom.sections.hero')
    @endif

    @if(!isset($setting->web_sections['academics']) || $setting->web_sections['academics'] == 1)
        @include('web.custom.sections.academics')
    @endif

    @if(!isset($setting->web_sections['why-choose-us']) || $setting->web_sections['why-choose-us'] == 1)
        @include('web.custom.sections.why-choose-us')
    @endif

    @if(!isset($setting->web_sections['campus-life']) || $setting->web_sections['campus-life'] == 1)
        @include('web.custom.sections.campus-life')
    @endif

    @if(!isset($setting->web_sections['clubs']) || $setting->web_sections['clubs'] == 1)
        @include('web.custom.sections.clubs')
    @endif

    @if(!isset($setting->web_sections['testimonials']) || $setting->web_sections['testimonials'] == 1)
        @include('web.custom.sections.testimonials')
    @endif

    @if(!isset($setting->web_sections['student-zone']) || $setting->web_sections['student-zone'] == 1)
        @include('web.custom.sections.student-portal')
    @endif

    @if(!isset($setting->web_sections['news-and-events']) || $setting->web_sections['news-and-events'] == 1)
        @include('web.custom.sections.events')
    @endif

    @if(!isset($setting->web_sections['apply']) || $setting->web_sections['apply'] == 1)
        @include('web.custom.sections.apply')
    @endif

    @if(!isset($setting->web_sections['faq']) || $setting->web_sections['faq'] == 1)
        @include('web.custom.sections.faq')
    @endif
@endsection
