@component('mail::message')
# Admission Application Received

Dear {{ $application->first_name }} {{ $application->last_name }},

Thank you for applying to **{{ config('app.name') }}**. We have successfully received your admission application.

### Admission Details:
- **Registration Number:** {{ $application->registration_no }}
- **Program:** {{ $application->program->title ?? 'N/A' }}
- **Apply Date:** {{ \Carbon\Carbon::parse($application->apply_date)->format('d M, Y') }}
- **Payment Status:** {{ $application->pay_status == 1 ? 'Paid' : 'Unpaid' }}

We will review your application and keep you updated on your admission status.

Thanks,  
{{ config('app.name') }}
@endcomponent
