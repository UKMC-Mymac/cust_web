<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Web\CampusLife;
use App\Models\Language;
use App\Services\BreadcrumbService;

class CampuslifeController extends Controller
{
    public function index()
    {
        $data['campuslife'] = CampusLife::query()
                            ->where('language_id', '=', Language::version()->id)
                            ->where('status', '=', '1')
                            ->orderBy('id', 'asc')
                            ->paginate(6);

        // Breadcrumb
        $breadcrumbData = BreadcrumbService::generate('campus-life', ['title' => 'Campus Life']);
        $data = array_merge($data, $breadcrumbData);

        return view('web.campuslife', $data);
    }

    public function show($slug)
    {
        $data['campuslife'] = CampusLife::query()
                    ->where('language_id', '=', Language::version()->id)
                    ->where('slug', '=', $slug)
                    ->where('status', '=', '1')
                            ->firstOrFail();

        // Breadcrumb
        $breadcrumbData = BreadcrumbService::generate('campus-life.show', ['title' => $data['campuslife']->title]);
        $data = array_merge($data, $breadcrumbData);

        return view('web.campuslife-single', $data);
    }
}