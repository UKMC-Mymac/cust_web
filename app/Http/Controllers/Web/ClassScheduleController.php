<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\ClassSchedule;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Session;
use App\Models\Batch;
use App\Services\BreadcrumbService;
use Illuminate\Http\Request;

class ClassScheduleController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Class Schedules';

        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();

        // Get filter inputs
        $data['selected_faculty'] = $request->get('faculty', null);
        $data['selected_program'] = $request->get('program', null);
        $data['selected_session'] = $request->get('session', null);
        $data['selected_batch'] = $request->get('batch', null);

        // Fetch dependent collections to keep dropdowns populated on reload
        if (!empty($data['selected_faculty'])) {
            $data['programs'] = Program::where('faculty_id', $data['selected_faculty'])->where('status', '1')->orderBy('title', 'asc')->get();
        } else {
            $data['programs'] = collect();
        }

        if (!empty($data['selected_program'])) {
            $program = Program::find($data['selected_program']);
            if ($program) {
                $data['sessions'] = $program->sessions()->where('status', '1')->orderBy('id', 'desc')->get();
                $data['batches'] = $program->batches()->where('status', '1')->orderBy('id', 'desc')->get();
            } else {
                $data['sessions'] = collect();
                $data['batches'] = collect();
            }
        } else {
            $data['sessions'] = collect();
            $data['batches'] = collect();
        }

        // Build query
        $query = ClassSchedule::where('status', '1')->orderBy('date', 'desc');

        if (!empty($data['selected_faculty'])) {
            $query->where('faculty_id', $data['selected_faculty']);
        }
        if (!empty($data['selected_program'])) {
            $query->where('program_id', $data['selected_program']);
        }
        if (!empty($data['selected_session'])) {
            $query->where('session_id', $data['selected_session']);
        }
        if (!empty($data['selected_batch'])) {
            $query->where(function($q) use ($data) {
                $q->where('batch_id', $data['selected_batch'])
                  ->orWhereHas('batches', function($sq) use ($data) {
                      $sq->where('batch_id', $data['selected_batch']);
                  });
            });
        }

        // Paginate results
        $data['results'] = $query->paginate(20);

        // Breadcrumbs
        $breadcrumbs = BreadcrumbService::generate('class-schedule', [
            'title' => $data['title'],
            'current_label' => $data['title']
        ]);
        $data = array_merge($data, $breadcrumbs);

        return view('web.class-schedule', $data);
    }

    public function show($id)
    {
        $classSchedule = ClassSchedule::where('status', '1')->findOrFail($id);

        $data['title'] = $classSchedule->title;
        $data['result'] = $classSchedule;

        // Get related class schedules
        $data['related_results'] = ClassSchedule::where('status', '1')
                                    ->where('program_id', $classSchedule->program_id)
                                    ->where('id', '!=', $classSchedule->id)
                                    ->orderBy('date', 'desc')
                                    ->limit(5)
                                    ->get();

        // Breadcrumbs
        $breadcrumbs = BreadcrumbService::generate('class-schedule.show', [
            'title' => $classSchedule->title,
            'current_label' => $classSchedule->title
        ]);
        $data = array_merge($data, $breadcrumbs);

        return view('web.class-schedule-single', $data);
    }
}
