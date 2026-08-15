<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Semester;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SemesterController extends Controller
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
        $this->title = trans_choice('module_semester', 1);
        $this->route = 'admin.semester';
        $this->view = 'admin.semester';
        $this->path = 'semester';
        $this->access = 'semester';

        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        $data['programs'] = Program::where('status', '1')
            ->orderBy('title', 'asc')->get();
        $data['rows'] = Semester::orderBy('id', 'asc')->get();

        return view($this->view.'.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:191',
            'year' => 'required',
            'programs' => 'required|array|min:1',
        ]);

        $this->ensureUniqueSemesterProgramCombination($request);

        // Insert Data
        $semester = new Semester;
        $semester->title = $request->title;
        $semester->year = $request->year;
        $semester->save();

        $semester->programs()->attach($request->programs);

        Flasher::addSuccess(__('msg_created_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Semester $semester)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Semester $semester)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Semester $semester)
    {
        $request->validate([
            'title' => 'required|max:191',
            'year' => 'required',
            'programs' => 'required|array|min:1',
        ]);

        $this->ensureUniqueSemesterProgramCombination($request, $semester->id);

        // Update Data
        $semester->title = $request->title;
        $semester->year = $request->year;
        $semester->status = $request->status;
        $semester->save();

        $semester->programs()->sync($request->programs);

        Flasher::addSuccess(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Semester $semester)
    {
        // Delete Data
        $semester->programs()->detach();
        $semester->delete();

        Flasher::addSuccess(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Ensure title + year + program is unique (e.g. Spring 2026 + Computer Engineering).
     */
    private function ensureUniqueSemesterProgramCombination(Request $request, ?int $ignoreSemesterId = null): void
    {
        $programIds = array_values(array_filter((array) $request->programs));

        if (empty($programIds)) {
            return;
        }

        $query = DB::table('program_semester')
            ->join('semesters', 'semesters.id', '=', 'program_semester.semester_id')
            ->where('semesters.title', $request->title)
            ->where('semesters.year', $request->year)
            ->whereIn('program_semester.program_id', $programIds);

        if ($ignoreSemesterId !== null) {
            $query->where('semesters.id', '!=', $ignoreSemesterId);
        }

        $conflictingProgramIds = $query
            ->pluck('program_semester.program_id')
            ->unique()
            ->values();

        if ($conflictingProgramIds->isEmpty()) {
            return;
        }

        $programNames = Program::whereIn('id', $conflictingProgramIds)
            ->orderBy('title')
            ->pluck('title')
            ->implode(', ');

        throw ValidationException::withMessages([
            'programs' => sprintf(
                '%s %s already exists for: %s.',
                $request->title,
                $request->year,
                $programNames
            ),
        ]);
    }
}
