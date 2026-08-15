<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Web\Apply;
use App\Models\Language;
use Flasher\Laravel\Facade\Flasher;
use App\Traits\FileUploader;

class ApplyController extends Controller
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
        $this->title   = 'Apply';
        $this->route   = 'admin.apply';
        $this->view    = 'admin.web.apply';
        $this->path    = 'apply';
        $this->access  = 'apply';

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

        $data['rows'] = Apply::query()->where('language_id', Language::version()->id)
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
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $items = $this->decodeItems($request->input('items'));
        $request->validate([
            'items' => 'required',
            'attach' => 'required|image',
            'url' => 'nullable|url',
            'button_text' => 'nullable|string|max:255',
            'description' => 'required|string',
            'status' => 'required|integer|in:0,1',
        ]);

        $this->validateItems($items);
        $apply = new Apply;
        $apply->language_id = Language::version()->id;
        $apply->items = $items;
        $apply->page_id = $request->input('page_id') ?: null;
        $apply->route_name = $request->input('route_name') ?: null;
        $apply->url = $request->input('url');
        $apply->button_text = $request->button_text;
        $apply->description = $request->description;
        $apply->attach = $this->uploadImage($request, 'attach', $this->path, 1024, 900);
        $apply->status = $request->status;    

        if ((int) $apply->status === 1) {
            $this->deactivateOtherRows($apply->language_id);
        }

        $apply->save();

        Flasher::addSuccess(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $items = $this->decodeItems($request->input('items'));
        $request->validate([
            'items' => 'required',
            'attach' => 'nullable|image',
            'url' => 'nullable|url',
            'button_text' => 'nullable|string|max:255',
            'description' => 'required|string',
            'status' => 'required|integer|in:0,1',
        ]);

        $this->validateItems($items);
        $apply = Apply::findOrFail($id);

        if ((int) $request->input('status') === 1) {
            $this->deactivateOtherRows($apply->language_id, $apply->id);
        }

        $apply->update([
            'items' => $items,
            'page_id' => $request->input('page_id') ?: null,
            'route_name' => $request->input('route_name') ?: null,
            'url' => $request->input('url'),
            'button_text' => $request->button_text,
            'attach' => $this->updateImage($request, 'attach', $this->path, 1024, 900, $apply, 'attach'),
            'description' => $request->description,
            'status' => $request->status,    
        ]);

        Flasher::addSuccess(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
            $apply = Apply::findOrFail($id);
            $this->deleteMedia($this->path, $apply);
            $apply->delete();
    
            Flasher::addSuccess(__('msg_deleted_successfully'), __('msg_success'));
    
            return redirect()->back();
    }

        private function decodeItems($items): array
        {
            if (is_array($items)) {
                return array_values(array_filter(array_map(function ($item) {
                    if (is_array($item)) {
                        return trim((string) ($item['title'] ?? $item['value'] ?? ''));
                    }

                    return trim((string) $item);
                }, $items), function ($item) {
                    return $item !== '';
                }));
            }

            if (is_string($items) && $items !== '') {
                $decoded = json_decode($items, true);

                return is_array($decoded) ? $this->decodeItems($decoded) : [];
            }

            return [];
        }

        private function validateItems(array $items): void
        {
            validator(['items' => $items], [
                'items' => ['required', 'array', 'min:1'],
                'items.*' => ['required', 'string', 'max:255'],
            ])->validate();
        }

        private function deactivateOtherRows(int $languageId, ?int $currentId = null): void
        {
            $query = Apply::query()->where('language_id', $languageId);

            if ($currentId !== null) {
                $query->whereKeyNot($currentId);
            }

            $query->update(['status' => 0]);
        }


}