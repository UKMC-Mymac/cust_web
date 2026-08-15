<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Result;
use App\Traits\FileUploader;
use Carbon\Carbon;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
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
        $this->title = trans_choice('module_result', 1);
        $this->route = 'admin.result';
        $this->view = 'admin.result';
        $this->path = 'result';
        $this->access = 'result';

        // Gate::before overrides these spatie checks if is_admin == 1.
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
    public function index(Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();

        // Filters
        $data['selected_title'] = $request->title;
        $data['selected_faculty'] = $request->faculty ?? '0';
        $data['selected_program'] = $request->program ?? '0';
        $data['selected_session'] = $request->session ?? '0';
        $data['selected_batch'] = $request->batch ?? '0';
        $data['selected_start_date'] = $request->start_date ?? date('Y-m-d', strtotime(Carbon::now()->subYear()));
        $data['selected_end_date'] = $request->end_date ?? date('Y-m-d', strtotime(Carbon::today()));

        $query = Result::whereDate('date', '>=', $data['selected_start_date'])
            ->whereDate('date', '<=', $data['selected_end_date']);

        if (! empty($request->title)) {
            $query->where('title', 'LIKE', '%'.$request->title.'%');
        }
        if (! empty($request->faculty) && $request->faculty != '0') {
            $query->where('faculty_id', $request->faculty);
            $data['programs'] = Program::where('faculty_id', $request->faculty)->where('status', '1')->orderBy('title', 'asc')->get();
        }
        if (! empty($request->program) && $request->program != '0') {
            $query->where('program_id', $request->program);

            $program = Program::find($request->program);
            if ($program) {
                $data['sessions'] = $program->sessions()->where('status', '1')->orderBy('id', 'desc')->get();
                $data['batches'] = $program->batches()->where('status', '1')->orderBy('id', 'desc')->get();
            }
        }
        if (! empty($request->session) && $request->session != '0') {
            $query->where('session_id', $request->session);
        }
        if (! empty($request->batch) && $request->batch != '0') {
            $query->where('batch_id', $request->batch);
        }

        $data['rows'] = $query->orderBy('date', 'desc')->get();

        return view($this->view.'.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;

        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();

        return view($this->view.'.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'faculty' => 'required|integer',
            'program' => 'required|integer',
            'session' => 'required|integer',
            'batch' => 'required|integer',
            'title' => 'required|max:191',
            'date' => 'required|date',
            'attach' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip,rar,csv,xls,xlsx,ppt,pptx|max:20480',
        ]);

        try {
            DB::beginTransaction();

            $result = new Result;
            $result->faculty_id = $request->faculty;
            $result->program_id = $request->program;
            $result->session_id = $request->session;
            $result->batch_id = $request->batch;
            $result->title = $request->title;
            $result->description = $request->description;
            $result->date = $request->date;
            $result->attach = $this->uploadMedia($request, 'attach', $this->path);
            $result->created_by = Auth::guard('web')->user()->id;
            $result->save();

            DB::commit();

            Flasher::addSuccess(__('msg_created_successfully'), __('msg_success'));

            return redirect()->route($this->route.'.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Flasher::addError(__('msg_created_error'), __('msg_error'));

            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Result $result)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        $data['row'] = $result;

        return view($this->view.'.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Result $result)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        $data['row'] = $result;

        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
        $data['programs'] = Program::where('faculty_id', $result->faculty_id)->where('status', '1')->orderBy('title', 'asc')->get();

        $program = Program::find($result->program_id);
        if ($program) {
            $data['sessions'] = $program->sessions()->where('status', '1')->orderBy('id', 'desc')->get();
            $data['batches'] = $program->batches()->where('status', '1')->orderBy('id', 'desc')->get();
        } else {
            $data['sessions'] = collect();
            $data['batches'] = collect();
        }

        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Result $result)
    {
        $request->validate([
            'faculty' => 'required|integer',
            'program' => 'required|integer',
            'session' => 'required|integer',
            'batch' => 'required|integer',
            'title' => 'required|max:191',
            'date' => 'required|date',
            'attach' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip,rar,csv,xls,xlsx,ppt,pptx|max:20480',
        ]);

        try {
            DB::beginTransaction();

            $result->faculty_id = $request->faculty;
            $result->program_id = $request->program;
            $result->session_id = $request->session;
            $result->batch_id = $request->batch;
            $result->title = $request->title;
            $result->description = $request->description;
            $result->date = $request->date;
            $result->attach = $this->updateMedia($request, 'attach', $this->path, $result);
            $result->status = $request->status;
            $result->updated_by = Auth::guard('web')->user()->id;
            $result->save();

            DB::commit();

            Flasher::addSuccess(__('msg_updated_successfully'), __('msg_success'));

            return redirect()->route($this->route.'.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Flasher::addError(__('msg_updated_error'), __('msg_error'));

            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Result $result)
    {
        try {
            DB::beginTransaction();

            // Delete Attach File
            $this->deleteMedia($this->path, $result);

            // Delete Data
            $result->delete();

            DB::commit();

            Flasher::addSuccess(__('msg_deleted_successfully'), __('msg_success'));

            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            Flasher::addError(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
