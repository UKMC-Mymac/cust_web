<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Web\School;
use App\Traits\FileUploader;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SchoolController extends Controller
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
        $this->title = 'School';
        $this->route = 'admin.school';
        $this->view = 'admin.web.school';
        $this->path = 'school';
        $this->access = 'course'; // Reuses course permission

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
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        $data['rows'] = School::where('language_id', Language::version()->id)
            ->orderBy('id', 'asc')
            ->get();

        return view($this->view.'.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
        $request->validate([
            'title' => 'required|unique:web_schools,title',
            'attach' => 'required|image',
        ]);

        $school = new School;
        $school->language_id = Language::version()->id;
        $school->title = $request->title;
        $school->slug = Str::slug($request->title, '-');
        $school->short_description = $request->short_description;
        $school->description = $request->description;
        $school->attach = $this->uploadImage($request, 'attach', $this->path, 800, 500);
        $school->save();

        Flasher::addSuccess(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(School $school)
    {
        // View via modal, usually blank or handled in index.blade.php
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $school)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['access'] = $this->access;
        $data['row'] = $school;

        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, School $school)
    {
        $request->validate([
            'title' => 'required|unique:web_schools,title,'.$school->id,
            'attach' => 'nullable|image',
        ]);

        $school->title = $request->title;
        $school->slug = Str::slug($request->title, '-');
        $school->short_description = $request->short_description;
        $school->description = $request->description;
        $school->attach = $this->updateImage($request, 'attach', $this->path, 800, 500, $school, 'attach');
        $school->status = $request->status;
        $school->save();

        Flasher::addSuccess(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
        $this->deleteMedia($this->path, $school);
        $school->delete();

        Flasher::addSuccess(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
