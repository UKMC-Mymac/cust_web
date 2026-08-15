<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Web\WebEvent;
use App\Services\BreadcrumbService;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Events
        $data['events'] = WebEvent::where('language_id', Language::version()->id)
            ->where('status', '1')
            ->orderByRaw('CASE WHEN pinned IS NULL THEN 1 ELSE 0 END')
            ->orderBy('pinned', 'asc')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->paginate(6);

        // Add breadcrumb
        $data = array_merge($data, BreadcrumbService::generate('event', [
            'title' => 'News & Events',
        ]));

        return view('web.event', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $slug)
    {
        // Event
        // $data['event'] = WebEvent::where('id', $id)
        //     ->where('status', '1')
        //     ->firstOrFail();
        $data['event'] = WebEvent::where('slug', $slug)
            ->where('id', $id)
            ->where('status', '1')
            ->firstOrFail();

        // Add breadcrumb
        $data = array_merge($data, BreadcrumbService::generate('event.show', [
            'title' => $data['event']->title,
            'current_label' => $data['event']->title,
        ]));

        return view('web.event-single', $data);
    }
}
