<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ApplicationSetting;
use App\Models\Program;
use App\Models\Province;
use App\Models\Semester;
use App\Traits\FileUploader;
use Carbon\Carbon;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    use FileUploader;

    protected $title;

    protected $route;

    protected $view;

    protected $path;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_application', 1);
        $this->route = 'application';
        $this->view = 'admin.application';
        $this->path = 'student';
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

        $data['programs'] = Program::where('status', '1')->orderBy('title', 'asc')->get();
        $data['semesters'] = Semester::where('status', '1')->orderBy('title', 'asc')->get();
        $data['provinces'] = Province::where('status', '1')->orderBy('title', 'asc')->get();
        $data['applicationSetting'] = ApplicationSetting::where('slug', 'admission')->where('status', '1')->firstOrFail();

        return view($this->view.'.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Field Validation
        $rules = [
            'program' => 'required',
            'first_name' => 'required',
            'last_name' => 'nullable',
            'national_id_file' => (\App\Models\Field::field('application_national_id_file') && \App\Models\Field::field('application_national_id_file')->status == 1) ? 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512' : 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'email' => 'required|email|unique:applications,email',
            'phone' => 'required',
            'gender' => 'required',
            'dob' => 'required|date',
            'photo' => 'nullable|image|max:1024', // 1 MB
            'signature' => 'nullable|image|max:300', // 300 KB

            'school_transcript' => (\App\Models\Field::field('application_school_transcript') && \App\Models\Field::field('application_school_transcript')->status == 1) ? 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512' : 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'school_certificate' => (\App\Models\Field::field('application_school_certificate') && \App\Models\Field::field('application_school_certificate')->status == 1) ? 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512' : 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',

            'collage_transcript' => (\App\Models\Field::field('application_collage_transcript') && \App\Models\Field::field('application_collage_transcript')->status == 1) ? 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512' : 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'collage_certificate' => (\App\Models\Field::field('application_collage_certificate') && \App\Models\Field::field('application_collage_certificate')->status == 1) ? 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512' : 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',

            'bachelor_transcript' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'bachelor_certificate' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',

            'other_edu_transcript' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'other_edu_certificate' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
        ];

        $request->validate($rules);

        // Insert Data
        try {
            DB::beginTransaction();

            $student = new Application;
            $student->program_id = $request->program;
            $student->apply_date = Carbon::today();

            $student->first_name = $request->first_name;
            $student->last_name = $request->last_name ?? '';
            $student->father_name = $request->father_name;
            $student->mother_name = $request->mother_name;
            $student->father_occupation = $request->father_occupation;
            $student->mother_occupation = $request->mother_occupation;

            $student->country = $request->country;
            $student->present_province = $request->present_province;
            $student->present_district = $request->present_district;
            $student->present_village = $request->present_village;
            $student->present_address = $request->present_address;
            $student->permanent_province = $request->permanent_province;
            $student->permanent_district = $request->permanent_district;
            $student->permanent_village = $request->permanent_village;
            $student->permanent_address = $request->permanent_address;

            $student->gender = $request->gender;
            $student->dob = $request->dob;
            $student->email = $request->email;
            $student->phone = $request->phone;
            $student->emergency_phone = $request->emergency_phone;

            $student->religion = $request->religion;
            $student->caste = $request->caste;
            $student->mother_tongue = $request->mother_tongue;
            $student->marital_status = $request->marital_status;
            $student->blood_group = $request->blood_group;
            $student->nationality = $request->nationality;
            $student->national_id = $request->national_id;
            $student->passport_no = $request->passport_no;

            $student->school_name = $request->school_name;
            $student->school_exam_id = $request->school_exam_id;
            $student->school_graduation_year = $request->school_graduation_year;
            $student->school_graduation_point = $request->school_graduation_point;
            $student->school_board = $request->school_board;
            $student->school_group = $request->school_group;

            $student->collage_name = $request->collage_name;
            $student->collage_exam_id = $request->collage_exam_id;
            $student->collage_graduation_year = $request->collage_graduation_year;
            $student->collage_graduation_point = $request->collage_graduation_point;
            $student->collage_board = $request->collage_board;
            $student->collage_group = $request->collage_group;

            $student->diploma_name = $request->diploma_name;
            $student->diploma_board = $request->diploma_board;
            $student->diploma_group = $request->diploma_group;
            $student->diploma_exam_id = $request->diploma_exam_id;
            $student->diploma_graduation_year = $request->diploma_graduation_year;
            $student->diploma_graduation_point = $request->diploma_graduation_point;

            $student->bachelor_name = $request->bachelor_name;
            $student->bachelor_board = $request->bachelor_board;
            $student->bachelor_group = $request->bachelor_group;
            $student->bachelor_exam_id = $request->bachelor_exam_id;
            $student->bachelor_graduation_year = $request->bachelor_graduation_year;
            $student->bachelor_graduation_point = $request->bachelor_graduation_point;

            $student->other_edu_name = $request->other_edu_name;
            $student->other_edu_board = $request->other_edu_board;
            $student->other_edu_group = $request->other_edu_group;
            $student->other_edu_exam_id = $request->other_edu_exam_id;
            $student->other_edu_graduation_year = $request->other_edu_graduation_year;
            $student->other_edu_graduation_point = $request->other_edu_graduation_point;

            $student->medical_condition = $request->medical_condition;
            $student->hostel_accommodation = $request->hostel_accommodation;
            $student->hostel_accommodation_text = $request->hostel_accommodation_text;
            $student->employment_status = $request->employment_status;
            $student->employment_text = $request->employment_text;
            $student->english_proficiency = $request->english_proficiency;
            $student->ielts_score = $request->ielts_score;
            $student->offense = $request->offense;
            $student->offense_text = $request->offense_text;
            $student->criminally_convicted = $request->criminally_convicted;
            $student->criminal_convicted_text = $request->criminal_convicted_text;

            $student->school_transcript = $this->uploadMedia($request, 'school_transcript', $this->path);
            $student->school_certificate = $this->uploadMedia($request, 'school_certificate', $this->path);
            $student->collage_transcript = $this->uploadMedia($request, 'collage_transcript', $this->path);
            $student->collage_certificate = $this->uploadMedia($request, 'collage_certificate', $this->path);
            $student->diploma_transcript = $this->uploadMedia($request, 'diploma_transcript', $this->path);
            $student->diploma_certificate = $this->uploadMedia($request, 'diploma_certificate', $this->path);
            $student->bachelor_transcript = $this->uploadMedia($request, 'bachelor_transcript', $this->path);
            $student->bachelor_certificate = $this->uploadMedia($request, 'bachelor_certificate', $this->path);
            $student->other_edu_transcript = $this->uploadMedia($request, 'other_edu_transcript', $this->path);
            $student->other_edu_certificate = $this->uploadMedia($request, 'other_edu_certificate', $this->path);
            $student->national_id_file = $this->uploadMedia($request, 'national_id_file', $this->path);

            $appSetting = ApplicationSetting::where('slug', 'admission')->where('status', '1')->first();

            $student->photo = $this->uploadImage($request, 'photo', $this->path, 300, 300);
            $student->signature = $this->uploadImage($request, 'signature', $this->path, 300, 100);
            $student->status = '1';
            $student->registration_no = 0;

            if ($appSetting && $appSetting->pay_online == 1 && $appSetting->fee_amount > 0) {
                $student->fee_amount = $appSetting->fee_amount;
                $student->pay_status = 0; // Unpaid
            } else {
                $student->fee_amount = 0;
                $student->pay_status = 1; // Paid / Free
            }

            $student->save();

            $student->registration_no = intval(10000000) + $student->id;
            $student->save();

            DB::commit();

            if ($appSetting && $appSetting->pay_online == 1 && $appSetting->fee_amount > 0) {
                return redirect()->route('application.payment', $student->id);
            }

            Flasher::addSuccess(__('msg_sent_successfully'), __('msg_success'));

            return redirect()->route('application.success', $student->id);
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::error('Application submission failed: '.$e->getMessage(), ['exception' => $e]);
            Flasher::addError(__('msg_created_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    /**
     * Show the payment gateway choice page.
     */
    public function payment($id)
    {
        $data['title'] = 'Application Payment';
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        $data['application'] = Application::findOrFail($id);

        // If already paid, redirect to success
        if ($data['application']->pay_status == 1) {
            return redirect()->route('application.success', $id);
        }

        $data['applicationSetting'] = ApplicationSetting::where('slug', 'admission')->where('status', '1')->firstOrFail();

        // If payment is not required, mark as paid and redirect to success
        if ($data['applicationSetting']->pay_online == 0 || $data['applicationSetting']->fee_amount <= 0) {
            $data['application']->pay_status = 1;
            $data['application']->fee_amount = 0;
            $data['application']->save();

            return redirect()->route('application.success', $id);
        }

        // Get enabled gateway
        $data['gateway'] = config('payment.status'); // bkash, nagad, sslcommerz, or none

        return view('admin.application.payment', $data);
    }

    /**
     * Show the payment success receipt/slip page.
     */
    public function success($id)
    {
        $data['title'] = 'Application Successful';
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        $data['application'] = Application::findOrFail($id);
        $data['applicationSetting'] = ApplicationSetting::where('slug', 'admission')->where('status', '1')->firstOrFail();

        // Map payment method to string
        $data['method_name'] = 'Online';
        if ($data['application']->payment_method == 11) {
            $data['method_name'] = 'bKash';
        } elseif ($data['application']->payment_method == 12) {
            $data['method_name'] = 'Nagad';
        } elseif ($data['application']->payment_method == 13) {
            $data['method_name'] = 'SSLCommerz';
        }

        return view('admin.application.success', $data);
    }
}
