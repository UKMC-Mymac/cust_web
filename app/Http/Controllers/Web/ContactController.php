<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Web\Contact;
use App\Models\MailSetting;
use App\Services\BreadcrumbService;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        $data['title'] = 'Contact Us';
        $data['contact'] = Contact::where('status', '1')->first();

        // Breadcrumbs
        $breadcrumbs = BreadcrumbService::generate('contact', ['title' => $data['title'], 'current_label' => $data['title']]);
        $data = array_merge($data, $breadcrumbs);

        return view('web.contact', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        try {
            $mailSetting = MailSetting::where('status', '1')->first();
            $recipient = $mailSetting ? $mailSetting->sender_email : config('mail.from.address');

            // Send email notification to admin
            Mail::to($recipient)
                ->send(new \App\Mail\ContactFormMail($validated));

            Flasher::addSuccess(__('Your message has been sent successfully! We will get back to you soon.'));
            return redirect()->route('contact')->with('success', __('Your message has been sent successfully! We will get back to you soon.'));
        } catch (\Exception $e) {
            Log::error('Contact form submission mail failed: ' . $e->getMessage());
            Flasher::addError(__('Failed to send message. Please try again later.'));
            return redirect()->route('contact')->with('error', __('Failed to send message. Please try again later.'));
        }
    }
}
