@component('mail::message')
# New Admission Application Received

A new student application has been submitted to **{{ config('app.name') }}**.

### Application Summary:
- **Registration Number:** {{ $application->registration_no }}
- **Applicant Name:** {{ $application->first_name }} {{ $application->last_name }}
- **Email:** {{ $application->email }}
- **Phone:** {{ $application->phone }}
- **Program Applied:** {{ $application->program->title ?? 'N/A' }}
- **Apply Date:** {{ \Carbon\Carbon::parse($application->apply_date)->format('d M, Y') }}

Please log in to the admin panel to review this application.

@component('mail::button', ['url' => route('admin.application.show', $application->id)])
View Application
@endcomponent

Thanks,  
{{ config('app.name') }}
@endcomponent
