<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Web\Testimonial;
use App\Models\Language;
use App\Services\BreadcrumbService;

class TestimonialsController extends Controller
{
    /**
     * Display a listing of the testimonials.
     */
    public function index()
    {
        $data['testimonials'] = Testimonial::query()
            ->where('language_id', '=', Language::version()->id)
            ->where('status', '=', '1')
            ->orderBy('id', 'asc')
            ->paginate(6);

        // Breadcrumb
        $breadcrumbData = BreadcrumbService::generate('testimonial', ['title' => 'Testimonials']);
        $data = array_merge($data, $breadcrumbData);

        return view('web.testimonial', $data);
    }

    /**
     * Display the specified testimonial.
     */
    public function show($slug)
    {
        $data['testimonial'] = Testimonial::query()
            ->where('language_id', '=', Language::version()->id)
            ->where('slug', '=', $slug)
            ->where('status', '=', '1')
            ->firstOrFail();

        // Breadcrumb
        $breadcrumbData = BreadcrumbService::generate('testimonial.show', ['title' => $data['testimonial']->name]);
        $data = array_merge($data, $breadcrumbData);

        return view('web.testimonial-single', $data);
    }
}
