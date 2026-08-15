<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Web\Course;
use App\Models\Web\Department;
use App\Traits\FileUploader;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
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
        $this->title = trans_choice('module_course', 1);
        $this->route = 'admin.course';
        $this->view = 'admin.web.course';
        $this->path = 'course';
        $this->access = 'course';

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

        $data['rows'] = Course::where('language_id', Language::version()->id)
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
        $data['departments'] = Department::where('language_id', Language::version()->id)
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
        // Field Validation
        $request->validate([
            'title' => 'required|unique:courses,title',
            'feature_text' => 'required|string',
            'fee' => 'nullable|numeric',
            'attach' => 'required|image',
            'department' => 'nullable|integer',
        ]);

        // Data Insert
        $course = new Course;
        $course->language_id = Language::version()->id;
        $course->department_id = $request->department;
        $course->title = $request->title;
        $course->feature_text = $request->feature_text;
        $course->slug = Str::slug($request->title, '-');
        $course->semesters = $request->semesters;
        $course->credits = $request->credits;
        $course->courses = $request->courses;
        $course->duration = $request->duration;
        $course->fee = $request->fee;
        $course->description = $request->description;
        $course->attach = $this->uploadImage($request, 'attach', $this->path, 800, 500);
        $course->save();

        Flasher::addSuccess(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['access'] = $this->access;

        $data['row'] = $course;
        $data['departments'] = Department::where('language_id', Language::version()->id)
            ->where('status', 1)
            ->orderBy('title', 'asc')
            ->get();

        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        // Field Validation
        $request->validate([
            'title' => 'required|unique:courses,title,'.$course->id,
            'fee' => 'nullable|numeric',
            'attach' => 'nullable|image',
            'department' => 'nullable|integer',
        ]);

        // Data Update
        $course->department_id = $request->department;
        $course->title = $request->title;
        $course->feature_text = $request->feature_text;
        $course->slug = Str::slug($request->title, '-');
        $course->semesters = $request->semesters;
        $course->credits = $request->credits;
        $course->courses = $request->courses;
        $course->duration = $request->duration;
        $course->fee = $request->fee;
        $course->description = $request->description;
        $course->attach = $this->updateImage($request, 'attach', $this->path, 800, 500, $course, 'attach');
        $course->status = $request->status;
        $course->update();

        Flasher::addSuccess(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        // Delete Attach
        $this->deleteMedia($this->path, $course);

        // Delete Data
        $course->delete();

        Flasher::addSuccess(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
