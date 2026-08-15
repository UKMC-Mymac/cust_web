<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Web\AboutUs;
use App\Models\Web\Apply;
use App\Models\Web\CallToAction;
use App\Models\Web\CampusLife;
use App\Models\Web\Course;
use App\Models\Web\Faq;
use App\Models\Web\Slider;
use App\Models\Web\Testimonial;
use App\Models\Web\WebEvent;
use App\Models\Web\WhyChooseUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Sliders
        $data['sliders'] = Slider::query()->where('language_id', Language::version()->id)
            ->where('status', '1')
            ->orderBy('id', 'asc')
            ->get();

        // Features
        $data['courses'] = Course::query()->with('department')
            ->where('language_id', Language::version()->id)
            ->where('status', '1')
            ->orderBy('id', 'asc')
            ->get();
        // About Us
        $data['about'] = AboutUs::query()->where('language_id', Language::version()->id)
            ->where('status', '1')
            ->first();

        // Call To Action
        $data['callToAction'] = CallToAction::query()->where('language_id', Language::version()->id)
            ->where('status', '1')
            ->first();

        // Testimonials
        $data['testimonials'] = Testimonial::query()->where('language_id', Language::version()->id)
            ->where('status', '1')
            ->orderBy('id', 'desc')
            ->get();

        // FAQ Section
        $data['faqs'] = Faq::query()->where('language_id', Language::version()->id)
            ->where('status', '1')
            ->orderBy('id', 'asc')
            ->limit(5)
            ->get();

        // Campus Life Section
        $data['campus_lifes'] = CampusLife::query()->where('language_id', Language::version()->id)
            ->where('status', '1')
            ->orderBy('id', 'asc')
            ->get();

        // Why Choose Us Section
        $data['why_choose_us'] = WhyChooseUs::query()->where('language_id', Language::version()->id)
            ->where('status', '1')
            ->first();
        $data['apply'] = Apply::query()->where('language_id', Language::version()->id)
            ->where('status', '1')
            ->first();

        $data['events'] = WebEvent::query()->where('language_id', Language::version()->id)
            ->where('status', '1')
            ->orderByRaw('CASE WHEN pinned IS NULL THEN 1 ELSE 0 END')
            ->orderBy('pinned', 'asc')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->limit(4)
            ->get();

        return view('web.custom.index', $data);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function setCookie(Request $request)
    {
        //
        if (Cookie::get('sidebar') != 'navbar-collapsed') {
            Cookie::queue(Cookie::make('sidebar', 'navbar-collapsed', 60 * 60 * 24 * 365));
        } else {
            Cookie::queue(Cookie::make('sidebar', 'navbar-expanded', 60 * 60 * 24 * 365));
        }

        return response()->json(['data' => Cookie::get('sidebar')]);
    }
}
