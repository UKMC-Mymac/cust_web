<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use App\Models\Setting;

class WebSectionController extends Controller
{
    protected $title, $route, $view, $path, $access;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = 'Web Sections Setting';
        $this->route = 'admin.web-sections';
        $this->view = 'admin.field';
        $this->access = 'setting';

        $this->middleware('permission:setting-view');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['access'] = $this->access;

        $data['row'] = Setting::where('status', '1')->first();

        return view($this->view.'.web-sections', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $setting = Setting::where('status', '1')->first();
        if (!$setting) {
            $setting = new Setting();
            $setting->status = 1;
            $setting->title = 'CUST';
        }

        $sections = [
            'hero' => $request->input('sections.hero', 0),
            'academics' => $request->input('sections.academics', 0),
            'why-choose-us' => $request->input('sections.why-choose-us', 0),
            'campus-life' => $request->input('sections.campus-life', 0),
            'clubs' => $request->input('sections.clubs', 0),
            'testimonials' => $request->input('sections.testimonials', 0),
            'student-zone' => $request->input('sections.student-zone', 0),
            'news-and-events' => $request->input('sections.news-and-events', 0),
            'apply' => $request->input('sections.apply', 0),
            'faq' => $request->input('sections.faq', 0),
        ];

        $setting->web_sections = $sections;
        $setting->save();

        Flasher::addSuccess(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
