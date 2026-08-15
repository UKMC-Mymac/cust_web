<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\EnvironmentVariable;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;

class PurchaseVerificationController extends Controller
{
    use EnvironmentVariable;

    protected $title, $route, $view, $path;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title    = 'Envato Purchase Verification';
        $this->route    = 'verify';
        $this->view     = 'verify';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['title']     = $this->title;
        $data['route']     = $this->route;
        $data['view']      = $this->view;

        return view($this->view, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        // Bypass purchase verification: always succeed
        $this->updateEnvVariable('ENVATO_LICENSE', '"bypassed"');
        Flasher::addSuccess('License check bypassed. Project unlocked.', 'Success');
        return redirect()->route('admin.dashboard.index');
    }
}
