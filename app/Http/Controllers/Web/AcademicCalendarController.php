<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\AcademicCalendar;
use App\Models\Session;
use App\Services\BreadcrumbService;
use Illuminate\Http\Request;

class AcademicCalendarController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Academic Calendars';

        $data['sessions'] = Session::where('status', '1')->orderBy('id', 'desc')->get();

        // Get filter inputs
        $data['selected_session'] = $request->get('session', null);

        // Build query
        $query = AcademicCalendar::where('status', '1')->orderBy('date', 'desc');

        if (!empty($data['selected_session'])) {
            $query->where('session_id', $data['selected_session']);
        }

        // Paginate results
        $data['results'] = $query->paginate(20);

        // Breadcrumbs
        $breadcrumbs = BreadcrumbService::generate('academic-calendar', [
            'title' => $data['title'],
            'current_label' => $data['title']
        ]);
        $data = array_merge($data, $breadcrumbs);

        return view('web.academic-calendar', $data);
    }

    public function show($id)
    {
        $academicCalendar = AcademicCalendar::where('status', '1')->findOrFail($id);

        $data['title'] = $academicCalendar->title;
        $data['result'] = $academicCalendar;

        // Get related calendars
        $data['related_results'] = AcademicCalendar::where('status', '1')
                                    ->where('id', '!=', $academicCalendar->id)
                                    ->orderBy('date', 'desc')
                                    ->limit(5)
                                    ->get();

        // Breadcrumbs
        $breadcrumbs = BreadcrumbService::generate('academic-calendar.show', [
            'title' => $academicCalendar->title,
            'current_label' => $academicCalendar->title
        ]);
        $data = array_merge($data, $breadcrumbs);

        return view('web.academic-calendar-single', $data);
    }
}
