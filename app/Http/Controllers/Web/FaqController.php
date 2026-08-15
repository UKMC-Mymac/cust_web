<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Web\Faq;
use App\Services\BreadcrumbService;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Faqs
        $data['faqs'] = Faq::where('language_id', Language::version()->id)
                            ->where('status', '1')
                            ->orderBy('id', 'asc')
                            ->paginate(10);

        // Breadcrumb
        $breadcrumbData = BreadcrumbService::generate('faq', ['title' => __('navbar_faqs')]);
        $data = array_merge($data, $breadcrumbData);

        return view('web.faq', $data);
    }
}
