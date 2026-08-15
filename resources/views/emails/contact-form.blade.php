@component('mail::message')
# New Contact Form Submission

You have received a new message from the contact form.

**From:** {{ $data['name'] }}  
**Email:** {{ $data['email'] }}  
@if (!empty($data['phone']))
**Phone:** {{ $data['phone'] }}  
@endif
**Subject:** {{ $data['subject'] }}

---

## Message

{{ $data['message'] }}

---

{{-- @component('mail::button', ['url' => route('admin.dashboard.index')])
View in Admin Panel 
@endcomponent. --}}

Thank you,  
{{ config('app.name') }}
@endcomponent