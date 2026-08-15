<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Web\Page;
use App\Services\BreadcrumbService;

class PageController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        // Page
        $data['page'] = Page::query()
                            ->where('slug', '=', $slug, 'and')
                            ->where('status', '=', 1, 'and')
                    ->firstOrFail();

        $data['builderSections'] = is_array($data['page']->builder_sections) ? $data['page']->builder_sections : [];
        $data['pagesById'] = Page::query()
            ->where('language_id', $data['page']->language_id)
            ->where('status', 1)
            ->orderBy('title', 'asc')
            ->get()
            ->keyBy('id');

        // Breadcrumbs
        $breadcrumbs = BreadcrumbService::generate('page', [
            'title' => $data['page']->display_text ?? $data['page']->title,
            'current_label' => $data['page']->display_text ?? $data['page']->title,
        ]);
        $data = array_merge($data, $breadcrumbs);

        return view('web.page', $data);
    }
}
