<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Web\School;
use App\Models\Web\Department;
use App\Traits\FileUploader;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DepartmentController extends Controller
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
        $this->title = 'Department';
        $this->route = 'admin.web-department';
        $this->view = 'admin.web.department';
        $this->path = 'department';
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

        $data['rows'] = Department::where('language_id', Language::version()->id)
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

        $data['schools'] = School::where('language_id', Language::version()->id)
            ->where('status', 1)
            ->orderBy('title', 'asc')
            ->get();

        return view($this->view.'.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'school' => 'required',
            'title' => 'required',
            'attach' => 'required|image',
        ]);

        $department = new Department;
        $department->language_id = Language::version()->id;
        $department->school_id = $request->school;
        $department->title = $request->title;
        $department->slug = Str::slug($request->title, '-');
        $department->short_description = $request->short_description;
        $department->attach = $this->uploadImage($request, 'attach', $this->path, 800, 500);
        $department->save();

        Flasher::addSuccess(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        // Handled in modal or list
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['access'] = $this->access;
        $data['row'] = $department;

        $data['schools'] = School::where('language_id', Language::version()->id)
            ->where('status', 1)
            ->orderBy('title', 'asc')
            ->get();

        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'school' => 'required',
            'title' => 'required',
            'attach' => 'nullable|image',
        ]);

        $department->school_id = $request->school;
        $department->title = $request->title;
        $department->slug = Str::slug($request->title, '-');
        $department->short_description = $request->short_description;
        $department->attach = $this->updateImage($request, 'attach', $this->path, 800, 500, $department, 'attach');
        $department->status = $request->status;
        $department->save();

        Flasher::addSuccess(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $this->deleteMedia($this->path, $department);
        $department->delete();

        Flasher::addSuccess(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
