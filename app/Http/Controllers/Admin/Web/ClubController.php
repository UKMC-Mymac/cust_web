<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use App\Models\Web\Club;

class ClubController extends Controller
{
    protected $title, $route, $view, $access;

    public function __construct()
    {
        $this->title   = 'Student Club';
        $this->route   = 'admin.club';
        $this->view    = 'admin.web.club';
        $this->access  = 'club';

        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-edit', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update']]);
    }

    public function index()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['access'] = $this->access;

        $data['rows'] = Club::query()
                        ->orderBy('id', 'asc')
                        ->get();

        return view($this->view.'.index', $data);
    }

    public function edit($id)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['access'] = $this->access;
        $data['row'] = Club::query()->findOrFail($id);
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
            'title' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'page_id' => 'nullable|exists:pages,id|required_without_all:link,route_name',
            'route_name' => ['nullable', 'string', 'in:'.implode(',', $internalRoutes)],
            'link' => 'nullable|string|required_without_all:page_id,route_name',
        ]);

        $club = Club::query()->findOrFail($id);

        $pageId = $request->page_id ?: null;
        $routeName = $pageId ? null : ($request->route_name ?: null);
        $link = ($pageId || $routeName) ? null : $request->link;

        $club->update([
            'title' => $request->title,
            'icon' => $request->icon,
            'page_id' => $pageId,
            'route_name' => $routeName,
            'link' => $link,
        ]);

        Flasher::addSuccess('Student Club updated successfully', 'Success');
        return redirect()->route($this->route.'.index');
    }
}
