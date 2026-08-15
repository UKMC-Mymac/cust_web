<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use App\Traits\FileUploader;
use App\Models\Web\CampusLife;
use App\Models\Language;
use Illuminate\Support\Str;

class CampusLifeController extends Controller
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
        $this->title   = 'Campus Life';
        $this->route   = 'admin.campus-life';
        $this->view    = 'admin.web.campus-life';
        $this->path    = 'campus-life';
        $this->access  = 'campus-life';

        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['title']  = $this->title;
        $data['route']  = $this->route;
        $data['view']   = $this->view;
        $data['path']   = $this->path;
        $data['access'] = $this->access;

        $query = CampusLife::query()->where('language_id', Language::version()->id);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('feature_text', 'like', "%{$search}%");
            });
            $data['search'] = $search;
        } else {
            $data['search'] = '';
        }

        $data['rows'] = $query->orderby('id', 'asc')->get();

        return view($this->view.'.index', $data);
    }

    public function create()
    {
        $data['title']  = $this->title;
        $data['route']  = $this->route;
        $data['view']   = $this->view;
        $data['path']   = $this->path;
        $data['access'] = $this->access;

        return view($this->view.'.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'feature_text' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'nullable|integer',
            'attach' => 'required|image',
            'button_text' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);
        
        $campusLife = new CampusLife();
        $campusLife->title = $request->title;
        $campusLife->feature_text = $request->feature_text;
        $campusLife->slug = Str::slug($request->title, '-');
        $campusLife->description = $request->description;
        $campusLife->status = $request->input('status', 1);
        $campusLife->button_text = $request->button_text;
        $campusLife->sort_order = $request->sort_order;
        $campusLife->language_id = Language::version()->id;
        $campusLife->attach = $this->uploadImage($request, 'attach', $this->path, 850, 500);
        $campusLife->save();
        Flasher::addSuccess(__('msg_created_successfully'), __('msg_success'));    
        return redirect()->route($this->route.'.index');
        }

    public function show(){
        
    }

    public function edit(CampusLife $campusLife){
        $data['title']  = $this->title;
        $data['route']  = $this->route;
        $data['view']   = $this->view;
        $data['path']   = $this->path;
        $data['access'] = $this->access;
        $data['row']    = $campusLife;

        return view($this->view.'.edit', $data);
    }

    public function update(Request $request, CampusLife $campusLife){
        $request->validate([
            'title' => 'required|string|max:255',
            'feature_text' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'nullable|integer',
            'attach' => 'nullable|image',
            'button_text' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $campusLife->title = $request->title;
        $campusLife->feature_text = $request->feature_text;
        $campusLife->slug = Str::slug($request->title, '-');
        $campusLife->description = $request->description;
        $campusLife->status = $request->input('status', 1);
        $campusLife->button_text = $request->button_text;
        $campusLife->sort_order = $request->sort_order;
        $campusLife->language_id = Language::version()->id;
        $campusLife->attach = $this->updateImage($request, 'attach', $this->path, 850, 500, $campusLife, 'attach');
        $campusLife->save();

        Flasher::addSuccess(__('msg_updated_successfully'), __('msg_success'));
        return redirect()->back();
    }

    public function destroy(CampusLife $campusLife){
        //Delete Attach
        $this->deleteMedia($this->path, $campusLife);

        //Delete Data
        CampusLife::query()->whereKey($campusLife->id)->delete();

        Flasher::addSuccess(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}