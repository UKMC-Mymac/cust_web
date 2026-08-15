<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Web\WhyChooseUs;
use App\Models\Language;
use Flasher\Laravel\Facade\Flasher;
use App\Traits\FileUploader;

class WhyChooseUsController extends Controller
{
    use FileUploader;

    protected $title, $route, $view, $path, $access;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title   = 'Why Choose Us';
        $this->route   = 'admin.why-choose-us';
        $this->view    = 'admin.web.why-choose-us';
        $this->path    = 'why-choose-us';
        $this->access  = 'why-choose-us';

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
        $data['path']   = $this->path;
        $data['access'] = $this->access;

        $data['rows'] = WhyChooseUs::query()->where('language_id', Language::version()->id)
                        ->orderby('id', 'asc')
                        ->get();

        $data['pages'] = \App\Models\Web\Page::query()
            ->where('language_id', Language::version()->id)
            ->where('status', 1)
            ->orderBy('title', 'asc')
            ->get();

        $data['internalRoutes'] = config('navbars.internal_links', []);

        return view($this->view.'.index', $data);
    }

        /**
        * Show the form for creating a new resource.
        */  
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $items = $this->decodeReasons($request->input('items'));
        $status = (int) $request->input('status');

        $request->validate([
            'items' => 'required',
            'status' => 'required|integer|in:0,1',
            'attach' => 'required|image',
            'url' => 'nullable|url',
            'button_text' => 'nullable|string|max:255',
        ]);

        $this->validateReasons($items);

        $whyChooseUs = new WhyChooseUs;
        $whyChooseUs->language_id = Language::version()->id;
        $whyChooseUs->items = $items;
        $whyChooseUs->url = $request->url;
        $whyChooseUs->button_text = $request->button_text;
        $whyChooseUs->status = $status;

        if ($status === 1) {
            $this->deactivateOtherRows($whyChooseUs->language_id);
        }

        $whyChooseUs->attach = $this->uploadImage($request, 'attach', $this->path, 950, 750);
        $whyChooseUs->save();

        Flasher::addSuccess(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(WhyChooseUs $whyChooseUs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WhyChooseUs $whyChooseUs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $items = $this->decodeReasons($request->input('items'));
        $whyChooseUs = WhyChooseUs::query()->findOrFail($id);
        $status = (int) $request->input('status');

        $request->validate([
            'items' => 'required',
            'status' => 'required|integer|in:0,1',
            'attach' => 'nullable|image',
            'url' => 'nullable|url',
            'button_text' => 'nullable|string|max:255',
        ]);

        $this->validateReasons($items);

        if ($status === 1) {
            $this->deactivateOtherRows($whyChooseUs->language_id, $whyChooseUs->id);
        }

        $whyChooseUs->update([
            'items' => $items,
            'url' => $request->url,
            'button_text' => $request->button_text,
            'status' => $status,
            'attach' => $this->updateImage($request, 'attach', $this->path, 950, 750, $whyChooseUs, 'attach'),
        ]);

        Flasher::addSuccess(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    private function decodeReasons($items): array
    {
        if (is_array($items)) {
            return $items;
        }

        if (is_string($items) && $items !== '') {
            $decoded = json_decode($items, true);

            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    private function validateReasons(array $items): void
    {
        validator(['items' => $items], [
            'items' => ['required', 'array', 'min:1'],
            'items.*.title' => ['required', 'string', 'max:255'],
            'items.*.description' => ['required', 'string'],
        ])->validate();
    }

    private function deactivateOtherRows(int $languageId, ?int $currentId = null): void
    {
        $query = WhyChooseUs::query()->where('language_id', $languageId);

        if ($currentId !== null) {
            $query->whereKeyNot($currentId);
        }

        $query->update(['status' => 0]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $whyChooseUs = WhyChooseUs::query()->findOrFail($id);

        // Delete Attach
        $this->deleteMedia($this->path, $whyChooseUs);

        // Delete Data
        $whyChooseUs->delete();

        Flasher::addSuccess(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }

    
}