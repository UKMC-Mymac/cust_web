<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Web\WebEvent;
use App\Traits\FileUploader;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WebEventController extends Controller
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
        $this->title = trans_choice('module_event', 1);
        $this->route = 'admin.web-event';
        $this->view = 'admin.web.web-event';
        $this->path = 'web-event';
        $this->access = 'web-event';

        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        $query = WebEvent::where('language_id', Language::version()->id);

        if (! empty($request->title)) {
            $query->where('title', 'like', '%'.$request->title.'%');
            $data['selected_title'] = $request->title;
        } else {
            $data['selected_title'] = null;
        }

        $data['rows'] = $query->orderBy('date', 'desc')->paginate(10);

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
            'date' => 'required|date',
            'address' => 'nullable|string|max:255',
            'feature_text' => 'nullable|string|max:255',
            'attach' => 'nullable|image',
            'pinned' => 'nullable|integer|min:1',
        ]);

        // Data Insert
        $webEvent = new WebEvent;
        $webEvent->language_id = Language::version()->id;
        $webEvent->title = $request->title;
        $webEvent->slug = $this->makeSlug($request->title);
        $webEvent->date = $request->date;
        $webEvent->time = $request->time;
        $webEvent->address = $request->address;
        $webEvent->description = $request->description;
        $webEvent->feature_text = $request->feature_text;
        $webEvent->attach = $this->uploadImage($request, 'attach', $this->path, 650, 400);
        $webEvent->pinned = $request->pinned;
        $webEvent->save();

        Flasher::addSuccess(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(WebEvent $webEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WebEvent $webEvent)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['access'] = $this->access;

        $data['row'] = $webEvent;

        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WebEvent $webEvent)
    {
        // Field Validation
        $request->validate([
            'title' => 'required',
            'address' => 'nullable|string|max:255',
            'feature_text' => 'nullable|string|max:255',
            'date' => 'required|date',
            'attach' => 'nullable|image',
            'pinned' => 'nullable|integer|min:1',
        ]);

        // Data Update
        $webEvent->title = $request->title;
        $webEvent->slug = $this->makeSlug($request->title);
        $webEvent->date = $request->date;
        $webEvent->time = $request->time;
        $webEvent->address = $request->address;
        $webEvent->description = $request->description;
        $webEvent->feature_text = $request->feature_text;
        $webEvent->attach = $this->updateImage($request, 'attach', $this->path, 650, 400, $webEvent, 'attach');
        $webEvent->status = $request->status;
        $webEvent->pinned = $request->pinned;
        $webEvent->update();

        Flasher::addSuccess(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WebEvent $webEvent)
    {
        // Delete Attach
        $this->deleteMedia($this->path, $webEvent);

        // Delete Data
        $webEvent->delete();

        Flasher::addSuccess(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Generate a Unicode-friendly slug.
     */
    private function makeSlug(string $title): string
    {
        $string = mb_strtolower(trim($title), 'UTF-8');
        
        // Strip out Zero Width Joiner (ZWJ) and Zero Width Non-Joiner (ZWNJ) characters
        $string = str_replace(["\u{200C}", "\u{200D}"], '', $string);

        // Replace all non-alphanumeric, non-mark characters with a hyphen (\p{M} preserves Bangla vowel signs and conjuncts)
        $slug = preg_replace('/[^\p{L}\p{N}\p{M}]+/u', '-', $string);
        
        // Trim excess hyphens
        return trim($slug, '-');
    }
}
