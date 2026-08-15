<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomUrl;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;

class CustomUrlController extends Controller
{
    protected $title;

    protected $route;

    protected $view;

    protected $path;

    protected $access;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = 'Custom URLs';
        $this->route = 'admin.custom-url';
        $this->view = 'admin.custom-url';
        $this->path = 'custom-url';
        $this->access = 'custom-url';

        // Limit this controller to super-admin role only
        $this->middleware('role:Super Admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        $data['rows'] = CustomUrl::orderBy('id', 'asc')->with('page')->get();
        $data['pages'] = \App\Models\Web\Page::query()
            ->where('status', 1)
            ->orderBy('title', 'asc')
            ->get();
        $data['internalRoutes'] = config('navbars.internal_links', []);

        return view($this->view.'.index', $data);
    }

    /**
     * Store a newly created resource in storage (for adding custom urls).
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $internalRoutes = array_keys(config('navbars.internal_links', []));

        $request->validate([
            'key' => 'required|unique:custom_urls,key',
            'title' => 'required',
            'page_id' => 'nullable|exists:pages,id|required_without_all:url,route_name',
            'route_name' => ['nullable', 'string', 'in:'.implode(',', $internalRoutes)],
            'url' => 'nullable|string|required_without_all:page_id,route_name',
        ]);

        $pageId = $request->page_id ?: null;
        $routeName = $pageId ? null : ($request->route_name ?: null);
        $url = ($pageId || $routeName) ? null : $request->url;

        $customUrl = new CustomUrl;
        $customUrl->key = $request->key;
        $customUrl->title = $request->title;
        $customUrl->page_id = $pageId;
        $customUrl->route_name = $routeName;
        $customUrl->url = $url;
        $customUrl->status = $request->status ?? 1;
        $customUrl->save();

        Flasher::addSuccess(__('msg_created_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $internalRoutes = array_keys(config('navbars.internal_links', []));

        $request->validate([
            'key' => 'required|unique:custom_urls,key,'.$id,
            'title' => 'required',
            'page_id' => 'nullable|exists:pages,id|required_without_all:url,route_name',
            'route_name' => ['nullable', 'string', 'in:'.implode(',', $internalRoutes)],
            'url' => 'nullable|string|required_without_all:page_id,route_name',
        ]);

        $pageId = $request->page_id ?: null;
        $routeName = $pageId ? null : ($request->route_name ?: null);
        $url = ($pageId || $routeName) ? null : $request->url;

        $customUrl = CustomUrl::findOrFail($id);
        $customUrl->key = $request->key;
        $customUrl->title = $request->title;
        $customUrl->page_id = $pageId;
        $customUrl->route_name = $routeName;
        $customUrl->url = $url;
        $customUrl->status = $request->status ?? 1;
        $customUrl->save();

        Flasher::addSuccess(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customUrl = CustomUrl::findOrFail($id);

        // Prevent deleting core seeded custom URLs if they are needed for the site structure
        $coreKeys = ['student_login', 'staff_login', 'privacy_policy', 'terms_of_service', 'copyright_link'];
        if (in_array($customUrl->key, $coreKeys)) {
            Flasher::addError('Core custom URLs cannot be deleted.', 'Error');

            return redirect()->back();
        }

        $customUrl->delete();

        Flasher::addSuccess(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
