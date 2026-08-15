<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use App\Models\Web\FooterSection;
use App\Models\Web\FooterLink;
use App\Models\Language;

class FooterSectionController extends Controller
{
    protected $title, $route, $view, $path, $access;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title   = 'Footer Section';
        $this->route   = 'admin.footer-section';
        $this->view    = 'admin.web.footer-section';
        $this->path    = 'footer-section';
        $this->access  = 'footer-section';

        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title']  = $this->title;
        $data['route']  = $this->route;
        $data['view']   = $this->view;
        $data['access'] = $this->access;

        $data['rows'] = FooterSection::query()->where('language_id', Language::version()->id)
                        ->orderby('sort_order', 'asc')
                        ->get();

        return view($this->view.'.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title']  = $this->title;
        $data['route']  = $this->route;
        $data['view']   = $this->view;
        $data['access'] = $this->access;

        return view($this->view.'.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Field Validation
        $request->validate([
            'title' => 'required',
            'sort_order' => 'required|numeric',
        ]);

        // Data Insert
        $section = new FooterSection;
        $section->language_id = Language::version()->id;
        $section->title = $request->title;
        $section->sort_order = $request->sort_order;
        $section->status = (int) $request->input('status', 0);
        $section->save();

        Flasher::addSuccess('Section created successfully', 'Success');

        return redirect()->route($this->route.'.edit', $section->id);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data['title']  = $this->title;
        $data['route']  = $this->route;
        $data['view']   = $this->view;
        $data['access'] = $this->access;

        $data['row'] = FooterSection::query()->find($id);

        return view($this->view.'.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['title']  = $this->title;
        $data['route']  = $this->route;
        $data['view']   = $this->view;
        $data['access'] = $this->access;

        $data['row'] = FooterSection::query()->with('links')->find($id);
        // Pages and internal routes for link assignment
        $data['pages'] = \App\Models\Web\Page::query()
            ->where('language_id', \App\Models\Language::version()->id)
            ->where('status', 1)
            ->orderBy('title', 'asc')
            ->get();

        $data['internalRoutes'] = config('navbars.internal_links', []);

        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Field Validation
        $request->validate([
            'title' => 'required',
            'sort_order' => 'required|numeric',
        ]);

        // Data Update
        $section = FooterSection::query()->find($id);
        $section->title = $request->title;
        $section->sort_order = $request->sort_order;
        $section->status = (int) $request->input('status', 0);
        $section->save();

        Flasher::addSuccess('Section updated successfully', 'Success');

        return redirect()->route($this->route.'.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        FooterSection::query()->find($id)->delete();

        Flasher::addSuccess('Section deleted successfully', 'Success');

        return redirect()->route($this->route.'.index');
    }

    /**
     * Store footer link
     */
    public function storeLink(Request $request, $sectionId)
    {
        $internalRoutes = array_keys(config('navbars.internal_links', []));

        $request->validate([
            'label' => 'required',
            'page_id' => 'nullable|exists:pages,id|required_without_all:url,route_name',
            'url' => 'nullable|string|required_without_all:page_id,route_name',
            'route_name' => ['nullable', 'string', 'in:'.implode(',', $internalRoutes)],
        ]);

        $pageId = $request->page_id ?: null;
        $routeName = $pageId ? null : ($request->route_name ?: null);
        $url = ($pageId || $routeName) ? null : $request->url;

        $link = new FooterLink;
        $link->footer_section_id = $sectionId;
        $link->label = $request->label;
        $link->page_id = $pageId;
        $link->route_name = $routeName;
        $link->url = $url;
        $link->sort_order = $request->sort_order ?? 0;
        $link->status = (int) $request->input('status', 0);
        $link->save();

        Flasher::addSuccess('Link created successfully', 'Success');

        return redirect()->back();
    }

    /**
     * Update footer link
     */
    public function updateLink(Request $request, $linkId)
    {
        $internalRoutes = array_keys(config('navbars.internal_links', []));

        $request->validate([
            'label' => 'required',
            'page_id' => 'nullable|exists:pages,id|required_without_all:url,route_name',
            'url' => 'nullable|string|required_without_all:page_id,route_name',
            'route_name' => ['nullable', 'string', 'in:'.implode(',', $internalRoutes)],
        ]);

        $link = FooterLink::query()->find($linkId);

        $pageId = $request->page_id ?: null;
        $routeName = $pageId ? null : ($request->route_name ?: null);
        $url = ($pageId || $routeName) ? null : $request->url;

        $link->label = $request->label;
        $link->page_id = $pageId;
        $link->route_name = $routeName;
        $link->url = $url;
        $link->sort_order = $request->sort_order ?? 0;
        $link->status = (int) $request->input('status', 0);
        $link->save();

        Flasher::addSuccess('Link updated successfully', 'Success');

        return redirect()->back();
    }

    /**
     * Delete footer link
     */
    public function destroyLink($linkId)
    {
        FooterLink::query()->find($linkId)->delete();

        Flasher::addSuccess('Link deleted successfully', 'Success');

        return redirect()->back();
    }
}
