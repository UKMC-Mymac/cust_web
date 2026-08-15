<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Web\Gallery;
use App\Models\Language;
use App\Services\BreadcrumbService;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Galleries
        $data['galleries'] = Gallery::where('language_id', Language::version()->id)
                            ->where('status', '1')
                            ->orderBy('id', 'desc')
                            ->get();

        // Breadcrumbs
        $breadcrumbs = BreadcrumbService::generate('gallery', ['title' => __('navbar_gallery')]);
        $data = array_merge($data, $breadcrumbs);

        return view('web.gallery', $data);
    }
}
