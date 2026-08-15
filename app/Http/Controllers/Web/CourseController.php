<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Web\Course;
use App\Models\Web\School;
use App\Models\Web\Department;
use App\Models\Language;
use App\Services\BreadcrumbService;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource (Lists Schools).
     */
    public function index()
    {
        // Schools
        $data['schools'] = School::query()->where('language_id', '=', Language::version()->id)
                    ->where('status', '=', '1')
                            ->orderBy('id', 'asc')
                            ->paginate(6);
        
       // Breadcrumb
       $breadcrumbData = BreadcrumbService::generate('course', ['title' => 'Schools']);
       $data = array_merge($data, $breadcrumbData);

        return view('web.course', $data);
    }

    /**
     * Display the specified School and its Departments.
     */
    public function show($slug)
    {
        // School
        $data['school'] = School::query()->where('slug', '=', $slug)
                    ->where('status', '=', '1')
                            ->firstOrFail();

        // Child Departments
        $data['departments'] = Department::query()->where('school_id', $data['school']->id)
                    ->where('status', '=', '1')
                    ->orderBy('id', 'asc')
                    ->get();
        
       // Breadcrumb
       $breadcrumbData = BreadcrumbService::generate('course.show', [
           'title' => $data['school']->title,
           'current_label' => $data['school']->title
       ]);
       $data = array_merge($data, $breadcrumbData);

        return view('web.course-single', $data);
    }

    /**
     * Display programs under the specified Department.
     */
    public function departmentPrograms($slug)
    {
        // Department
        $data['department'] = Department::query()->where('slug', '=', $slug)
                    ->where('status', '=', '1')
                    ->firstOrFail();

        // Programs (Courses) under Department
        $data['courses'] = Course::query()->where('department_id', $data['department']->id)
                    ->where('status', '=', '1')
                    ->orderBy('id', 'asc')
                    ->paginate(6);

        // Breadcrumb
        $breadcrumbData = BreadcrumbService::generate('course.show', [
            'title' => $data['department']->title,
            'current_label' => $data['department']->title
        ]);
        $data = array_merge($data, $breadcrumbData);

        return view('web.department-single', $data);
    }

    /**
     * Display details of a single Program.
     */
    public function programSingle($slug)
    {
        // Program (Course)
        $data['course'] = Course::query()->where('slug', '=', $slug)
                    ->where('status', '=', '1')
                    ->firstOrFail();

        // Breadcrumb
        $breadcrumbData = BreadcrumbService::generate('program.show', [
            'title' => $data['course']->title,
            'current_label' => $data['course']->title
        ]);
        $data = array_merge($data, $breadcrumbData);

        return view('web.program-single', $data);
    }

    /**
     * Display a listing of all Programs.
     */
    public function allPrograms()
    {
        // Programs
        $data['courses'] = Course::query()->where('language_id', '=', Language::version()->id)
                    ->where('status', '=', '1')
                    ->orderBy('id', 'asc')
                    ->paginate(6);

        // Breadcrumb
        $breadcrumbData = BreadcrumbService::generate('program', ['title' => 'Programs']);
        $data = array_merge($data, $breadcrumbData);

        return view('web.all-programs', $data);
    }
}
