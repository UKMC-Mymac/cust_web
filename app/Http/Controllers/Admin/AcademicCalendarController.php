<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicCalendar;
use App\Models\Session;
use App\Traits\FileUploader;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AcademicCalendarController extends Controller
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
        $this->title = trans_choice('module_academic_calendar', 1);
        $this->route = 'admin.academic-calendar';
        $this->view = 'admin.academic-calendar';
        $this->path = 'academic-calendar';
        $this->access = 'academic-calendar';

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

        $data['sessions'] = Session::where('status', '1')->orderBy('id', 'desc')->get();

        // Filters
        $data['selected_title'] = $request->title;
        $data['selected_session'] = $request->session ?? '0';

        $query = AcademicCalendar::query();

        if (! empty($request->title)) {
            $query->where('title', 'LIKE', '%'.$request->title.'%');
        }
        if (! empty($request->session) && $request->session != '0') {
            $query->where('session_id', $request->session);
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

        $data['sessions'] = Session::where('status', '1')->orderBy('id', 'desc')->get();

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
            'session' => 'required|integer',
            'title' => 'required|max:191',
            'date' => 'required|date',
            'attach' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip,rar,csv,xls,xlsx,ppt,pptx|max:20480',
        ]);

        try {
            DB::beginTransaction();

            $academicCalendar = new AcademicCalendar;
            $academicCalendar->session_id = $request->session;
            $academicCalendar->title = $request->title;
            $academicCalendar->description = $request->description;
            $academicCalendar->date = $request->date;
            $academicCalendar->attach = $this->uploadMedia($request, 'attach', $this->path);
            $academicCalendar->created_by = Auth::guard('web')->user()->id;
            $academicCalendar->save();

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
    public function show(AcademicCalendar $academicCalendar)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        $data['row'] = $academicCalendar;

        return view($this->view.'.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(AcademicCalendar $academicCalendar)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        $data['row'] = $academicCalendar;
        $data['sessions'] = Session::where('status', '1')->orderBy('id', 'desc')->get();

        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AcademicCalendar $academicCalendar)
    {
        $request->validate([
            'session' => 'required|integer',
            'title' => 'required|max:191',
            'date' => 'required|date',
            'attach' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip,rar,csv,xls,xlsx,ppt,pptx|max:20480',
        ]);

        try {
            DB::beginTransaction();

            $academicCalendar->session_id = $request->session;
            $academicCalendar->title = $request->title;
            $academicCalendar->description = $request->description;
            $academicCalendar->date = $request->date;
            $academicCalendar->attach = $this->updateMedia($request, 'attach', $this->path, $academicCalendar);
            $academicCalendar->status = $request->status;
            $academicCalendar->updated_by = Auth::guard('web')->user()->id;
            $academicCalendar->save();

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
    public function destroy(AcademicCalendar $academicCalendar)
    {
        try {
            DB::beginTransaction();

            // Delete Attach File
            $this->deleteMedia($this->path, $academicCalendar);

            // Delete Data
            $academicCalendar->delete();

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
