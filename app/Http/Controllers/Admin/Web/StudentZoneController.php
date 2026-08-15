<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use App\Models\Web\StudentZone;
use App\Traits\FileUploader;

class StudentZoneController extends Controller
{
    use FileUploader;

    protected $title, $route, $view, $path, $access;

    public function __construct()
    {
        $this->title   = 'Student Zone';
        $this->route   = 'admin.student-zone';
        $this->view    = 'admin.web.student-zone';
        $this->path    = 'student-zone';
        $this->access  = 'student-zone';

        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['access'] = $this->access;

        $data['rows'] = StudentZone::query()
                        ->orderBy('order', 'asc')
                        ->get();

        return view($this->view.'.index', $data);
    }

    public function create()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['access'] = $this->access;
        $data['pages'] = \App\Models\Web\Page::query()
            ->where('status', 1)
            ->orderBy('title', 'asc')
            ->get();
        $data['internalRoutes'] = config('navbars.internal_links', []);

        return view($this->view.'.create', $data);
    }

    public function store(Request $request)
    {
        $internalRoutes = array_keys(config('navbars.internal_links', []));

        $request->validate([
            'title' => 'required|string',
            'icon_url' => 'nullable|image',
            'page_id' => 'nullable|exists:pages,id|required_without_all:link,route_name',
            'route_name' => ['nullable', 'string', 'in:'.implode(',', $internalRoutes)],
            'link' => 'nullable|string|required_without_all:page_id,route_name',
            'order' => 'nullable|numeric',
        ]);

        $pageId = $request->page_id ?: null;
        $routeName = $pageId ? null : ($request->route_name ?: null);
        $link = ($pageId || $routeName) ? null : $request->link;
        $iconUrl = $request->hasFile('icon_url') ? $this->uploadImage($request, 'icon_url', $this->path, 400, null) : null;

        StudentZone::create([
            'title' => $request->title,
            'icon_url' => $iconUrl,
            'page_id' => $pageId,
            'route_name' => $routeName,
            'link' => $link,
            'order' => $request->order ?? 0,
            'status' => (int) $request->input('status', 1),
        ]);

        Flasher::addSuccess('Student Zone created successfully', 'Success');
        return redirect()->route($this->route.'.index');
    }

    public function edit($id)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['access'] = $this->access;
        $data['row'] = StudentZone::query()->find($id);
        $data['pages'] = \App\Models\Web\Page::query()
            ->where('status', 1)
            ->orderBy('title', 'asc')
            ->get();
        $data['internalRoutes'] = config('navbars.internal_links', []);

        return view($this->view.'.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $internalRoutes = array_keys(config('navbars.internal_links', []));

        $request->validate([
            'title' => 'required|string',
            'icon_url' => 'nullable|image',
            'page_id' => 'nullable|exists:pages,id|required_without_all:link,route_name',
            'route_name' => ['nullable', 'string', 'in:'.implode(',', $internalRoutes)],
            'link' => 'nullable|string|required_without_all:page_id,route_name',
            'order' => 'nullable|numeric',
        ]);

        $zone = StudentZone::query()->find($id);

        $pageId = $request->page_id ?: null;
        $routeName = $pageId ? null : ($request->route_name ?: null);
        $link = ($pageId || $routeName) ? null : $request->link;
        $iconUrl = $this->updateImage($request, 'icon_url', $this->path, 400, null, $zone, 'icon_url');

        $zone->update([
            'title' => $request->title,
            'icon_url' => $iconUrl,
            'page_id' => $pageId,
            'route_name' => $routeName,
            'link' => $link,
            'order' => $request->order ?? 0,
            'status' => (int) $request->input('status', 1),
        ]);

        Flasher::addSuccess('Student Zone updated successfully', 'Success');
        return redirect()->route($this->route.'.index');
    }

    public function destroy($id)
    {
        $zone = StudentZone::query()->find($id);
        $this->deleteMedia($this->path, $zone);
        $zone->delete();
        Flasher::addSuccess('Student Zone deleted successfully', 'Success');
        return redirect()->route($this->route.'.index');
    }
}
