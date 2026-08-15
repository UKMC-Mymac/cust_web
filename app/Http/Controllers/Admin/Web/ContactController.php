<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Flasher\Laravel\Facade\Flasher;
use App\Models\Web\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    protected $title, $route, $view, $path, $access;

    public function __construct(){
        // Module Data
        $this->title   = 'Contact';
        $this->route   = 'admin.contact';
        $this->view    = 'admin.web.contact';
        $this->path    = 'contact';
        $this->access  = 'contact';

        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }

    

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title']  = $this->title;
        $data['route']  = $this->route;
        $data['view']   = $this->view;
        $data['path']   = $this->path;
        $data['access'] = $this->access;

        $data['rows'] = Contact::query()
                        ->orderby('id', 'asc')
                        ->get();

         return view($this->view.'.index', $data);
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title']  = $this->title;
        $data['route']  = $this->route;
        $data['view']   = $this->view;

        return view($this->view.'.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255',
            'website'=>'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'map_link' => 'nullable|url',
            'status' => 'required|in:0,1'
        ]);

        $contact = new Contact;
        $contact->title = $request->title;
        $contact->subtitle = $request->subtitle;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->website = $request->website;
        $contact->address = $request->address;
        $contact->description = $request->description;
        $contact->map_link = $request->map_link;
        $contact->status = $request->status;
        $contact->save();
        // If this contact is set active, deactivate other contacts
        if ($contact->status == 1) {
            Contact::where('id', '!=', $contact->id)->where('status', 1)->update(['status' => 0]);
        }

        Flasher::addSuccess('Contact created successfully.');
        return redirect()->route($this->route.'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['title']  = $this->title;
        $data['route']  = $this->route;
        $data['view']   = $this->view;
        $data['row']    = Contact::findOrFail($id);

        return view($this->view.'.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['title']  = $this->title;
        $data['route']  = $this->route;
        $data['view']   = $this->view;
        $data['row']    = Contact::findOrFail($id);

        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website'=>'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'map_link' => 'nullable|url',
            'status' => 'required|in:0,1'
        ]);

        $contact = Contact::findOrFail($id);
        $contact->title = $request->title;
        $contact->subtitle = $request->subtitle;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->website = $request->website;
        $contact->address = $request->address;
        $contact->description = $request->description;
        $contact->map_link = $request->map_link;
        $contact->status = $request->status;
        $contact->save();
        // If this contact is set active, deactivate other contacts
        if ($contact->status == 1) {
            Contact::where('id', '!=', $contact->id)->where('status', 1)->update(['status' => 0]);
        }

        Flasher::addSuccess('Contact updated successfully.');
        return redirect()->route($this->route.'.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        Flasher::addSuccess('Contact deleted successfully.');
        return redirect()->route($this->route.'.index');
    }
}