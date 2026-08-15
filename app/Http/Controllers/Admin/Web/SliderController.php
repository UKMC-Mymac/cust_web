<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Web\Page;
use App\Models\Web\Slider;
use App\Traits\FileUploader;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    use FileUploader;

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
        $this->title = trans_choice('module_slider', 1);
        $this->route = 'admin.slider';
        $this->view = 'admin.web.slider';
        $this->path = 'slider';
        $this->access = 'slider';

        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $data['pages'] = Page::query()
            ->where('language_id', Language::version()->id)
            ->where('status', 1)
            ->orderBy('title', 'asc')
            ->get();
        $data['internalRoutes'] = config('navbars.internal_links', []);

        $data['rows'] = Slider::where('language_id', Language::version()->id)
            ->orderby('id', 'asc')
            ->get();

        return view($this->view.'.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['access'] = $this->access;
        $data['pages'] = Page::query()
            ->where('language_id', Language::version()->id)
            ->where('status', 1)
            ->orderBy('title', 'asc')
            ->get();
        $data['internalRoutes'] = config('navbars.internal_links', []);

        return view($this->view.'.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Field Validation
        $internalRoutes = array_keys(config('navbars.internal_links', []));

        $request->validate([
            'title' => 'required|unique:sliders,title',
            // 'page_id' => 'nullable|exists:pages,id|required_without_all:button_link,route_name',
            // 'button_link' => 'nullable|url|required_without_all:page_id,route_name',
            'page_id' => 'nullable|exists:pages,id',
            'button_link' => 'nullable|url',
            'page_id_2' => 'nullable|exists:pages,id',
            'button_link_2' => 'nullable|url',
            'route_name' => ['nullable', 'string', 'in:'.implode(',', $internalRoutes)],
            'video_url' => 'nullable|url',

            // 'page_id_2' => 'nullable|exists:pages,id|required_without_all:button_link_2,route_name_2',
            // 'button_link_2' => 'nullable|url|required_without_all:page_id_2,route_name_2',
            'route_name_2' => ['nullable', 'string', 'in:'.implode(',', $internalRoutes)],
            'video_url' => 'nullable|url',

            'attach' => 'required|image',
        ]);

        // Data Insert
        $slider = new Slider;
        $slider->language_id = Language::version()->id;
        $slider->title = $request->title;
        $slider->sub_title = $request->sub_title;
        $slider->button_text = $request->button_text;
        $pageId = $request->page_id ?: null;
        $routeName = $pageId ? null : ($request->route_name ?: null);
        $buttonLink = ($pageId || $routeName) ? null : $request->button_link;

        $slider->page_id = $pageId;
        $slider->route_name = $routeName;
        $slider->button_link = $buttonLink;
        $slider->button_text_2 = $request->button_text_2;
        $pageId2 = $request->page_id_2 ?: null;
        $routeName2 = $pageId2 ? null : ($request->route_name_2 ?: null);
        $buttonLink2 = ($pageId2 || $routeName2) ? null : $request->button_link_2;

        $slider->page_id_2 = $pageId2;
        $slider->route_name_2 = $routeName2;
        $slider->button_link_2 = $buttonLink2;
        $slider->attach = $this->uploadImage($request, 'attach', $this->path, 1920, 850);
        $slider->video_url = $request->video_url ?: null;
        $slider->save();

        Flasher::addSuccess(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['access'] = $this->access;
        $data['pages'] = Page::query()
            ->where('language_id', Language::version()->id)
            ->where('status', 1)
            ->orderBy('title', 'asc')
            ->get();
        $data['internalRoutes'] = config('navbars.internal_links', []);

        $data['row'] = $slider;

        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        // Field Validation
        $internalRoutes = array_keys(config('navbars.internal_links', []));

        $request->validate([
            'title' => 'required|unique:sliders,title,'.$slider->id,
            // 'page_id' => 'nullable|exists:pages,id|required_without_all:button_link,route_name',
            // 'button_link' => 'nullable|url|required_without_all:page_id,route_name',
            'page_id' => 'nullable|exists:pages,id',
            'button_link' => 'nullable|url',
            'page_id_2' => 'nullable|exists:pages,id',
            'button_link_2' => 'nullable|url',
            'route_name' => ['nullable', 'string', 'in:'.implode(',', $internalRoutes)],
            'video_url' => 'nullable|url',

            // 'page_id_2' => 'nullable|exists:pages,id|required_without_all:button_link_2,route_name_2',
            // 'button_link_2' => 'nullable|url|required_without_all:page_id_2,route_name_2',
            'route_name_2' => ['nullable', 'string', 'in:'.implode(',', $internalRoutes)],

            'attach' => 'nullable|image',
        ]);

        // Data Update
        $slider->title = $request->title;
        $slider->sub_title = $request->sub_title;
        $slider->button_text = $request->button_text;
        $pageId = $request->page_id ?: null;
        $routeName = $pageId ? null : ($request->route_name ?: null);
        $buttonLink = ($pageId || $routeName) ? null : $request->button_link;

        $slider->page_id = $pageId;
        $slider->route_name = $routeName;
        $slider->button_link = $buttonLink;
        $slider->button_text_2 = $request->button_text_2;
        $pageId2 = $request->page_id_2 ?: null;
        $routeName2 = $pageId2 ? null : ($request->route_name_2 ?: null);
        $buttonLink2 = ($pageId2 || $routeName2) ? null : $request->button_link_2;

        $slider->page_id_2 = $pageId2;
        $slider->route_name_2 = $routeName2;
        $slider->button_link_2 = $buttonLink2;
        $slider->attach = $this->updateImage($request, 'attach', $this->path, 1920, 850, $slider, 'attach');
        $slider->video_url = $request->video_url ?: null;
        $slider->status = $request->status;
        $slider->update();

        Flasher::addSuccess(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        // Delete Attach
        $this->deleteMedia($this->path, $slider);

        // Delete Data
        $slider->delete();

        Flasher::addSuccess(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
