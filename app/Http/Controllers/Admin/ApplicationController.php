<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Batch;
use App\Models\District;
use App\Models\Document;
use App\Models\EnrollSubject;
use App\Models\Program;
use App\Models\Province;
use App\Models\StatusType;
use App\Models\Student;
use App\Models\StudentEnroll;
use App\Models\StudentRelative;
use App\Models\ApplicationSetting;
use App\Traits\FileUploader;
use Carbon\Carbon;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ApplicationController extends Controller
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
        $this->title = trans_choice('module_application', 1);
        $this->route = 'admin.application';
        $this->view = 'admin.application';
        $this->path = 'student';
        $this->access = 'application';

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
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        $batch = $request->has('batch') ? $request->batch : '0';
        $program = $request->has('program') ? $request->program : '0';
        $status = $request->has('status') ? $request->status : '1';
        $registration_no = $request->registration_no;

        $data['selected_batch'] = $batch;
        $data['selected_program'] = $program;
        $data['selected_status'] = $status;
        $data['selected_registration_no'] = $registration_no;

        if (! empty($request->start_date) || $request->start_date != null) {
            $data['selected_start_date'] = $start_date = $request->start_date;
        } else {
            $data['selected_start_date'] = $start_date = date('Y-m-d', strtotime(Carbon::now()->subYear()));
        }

        if (! empty($request->end_date) || $request->end_date != null) {
            $data['selected_end_date'] = $end_date = $request->end_date;
        } else {
            $data['selected_end_date'] = $end_date = date('Y-m-d', strtotime(Carbon::today()));
        }

        // Search Filter
        $data['batches'] = Batch::where('status', '1')->orderBy('id', 'desc')->get();
        $data['programs'] = Program::where('status', '1')->orderBy('title', 'asc')->get();

        // Application Filter / Query is run by default
        $applications = Application::query()
            ->whereDate('apply_date', '>=', $start_date)
            ->whereDate('apply_date', '<=', $end_date);

        if (! empty($batch) && $batch != '0') {
            $applications->where('batch_id', $batch);
        }
        if (! empty($program) && $program != '0') {
            $applications->where('program_id', $program);
        }
        if (! empty($registration_no)) {
            $applications->where('registration_no', 'LIKE', '%'.$registration_no.'%');
        }
        if ($status !== null && $status !== '') {
            $applications->where('status', $status);
        }

        $data['rows'] = $applications->orderBy('registration_no', 'desc')->get();

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
        $data['path'] = $this->path;

        $data['programs'] = Program::where('status', '1')->orderBy('title', 'asc')->get();
        $data['provinces'] = Province::where('status', '1')->orderBy('title', 'asc')->get();
        $data['applicationSetting'] = ApplicationSetting::where('slug', 'admission')->where('status', '1')->first();

        return view($this->view.'.create-offline', $data);
    }

    /**
     * Store a newly created offline resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeOffline(Request $request)
    {
        $request->validate([
            'program' => 'required',
            'first_name' => 'required',
            'email' => 'required|email|unique:applications,email',
            'phone' => 'required',
            'gender' => 'required',
            'dob' => 'required|date',
            'collected_fees' => 'required|numeric|min:0',
            // File validations (all optional)
            'photo' => 'nullable|image|max:1024',
            'signature' => 'nullable|image|max:300',
            'school_transcript' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'school_certificate' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'collage_transcript' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'collage_certificate' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'bachelor_transcript' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'bachelor_certificate' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'other_edu_transcript' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'other_edu_certificate' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'national_id_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
        ]);

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

            $student->photo = $this->uploadImage($request, 'photo', $this->path, 300, 300);
            $student->signature = $this->uploadImage($request, 'signature', $this->path, 300, 100);
            $student->status = '1';
            $student->registration_no = 0;

            // Save Offline Collected Fees
            $student->fee_amount = $request->collected_fees;
            $student->pay_status = 1; // Paid manually
            $student->payment_method = 2; // Cash (Offline)
            $student->created_by = Auth::guard('web')->user()->id;

            $student->save();

            $student->registration_no = intval(10000000) + $student->id;
            $student->save();

            DB::commit();

            Flasher::addSuccess(__('msg_created_successfully'), __('msg_success'));

            return redirect()->route($this->route.'.index');
        } catch (\Exception $e) {
            DB::rollBack();
            Flasher::addError(__('msg_created_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = Application::where('registration_no', $request->registration_no)->firstOrFail();

        $isPaidOnline = ($data->pay_status == 1 && in_array($data->payment_method, [11, 12, 13]));

        $rules = [
            'student_id' => 'required|unique:students,student_id',
            'batch' => 'required',
            'program' => 'required',
            'session' => 'required',
            // 'semester' => 'required',
            // 'section' => 'required',
            'first_name' => 'required',
            'last_name' => 'nullable',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required',
            'gender' => 'required',
            'dob' => 'required|date',
            'admission_date' => 'required|date',
        ];

        if (!$isPaidOnline) {
            $rules['collected_fees'] = 'required|numeric|min:0';
        }

        $request->validate(array_merge($rules, $this->applicationFileValidationRules()));

        // Random Password
        $password = str_random(8);

        // Insert Data
        try {
            DB::beginTransaction();

            $application = new Student;
            $application->student_id = $request->student_id;
            $application->registration_no = $request->registration_no;
            $application->batch_id = $request->batch;
            $application->program_id = $request->program;
            $application->admission_date = $request->admission_date;

            $application->first_name = $request->first_name;
            $application->last_name = $request->last_name ?? '';
            $application->father_name = $request->father_name;
            $application->mother_name = $request->mother_name;
            $application->father_occupation = $request->father_occupation;
            $application->mother_occupation = $request->mother_occupation;
            $application->email = $request->email;
            $application->password = Hash::make($password);
            $application->password_text = Crypt::encryptString($password);

            $application->country = $request->country;
            $application->present_province = $request->present_province;
            $application->present_district = $request->present_district;
            $application->present_village = $request->present_village;
            $application->present_address = $request->present_address;
            $application->permanent_province = $request->permanent_province;
            $application->permanent_district = $request->permanent_district;
            $application->permanent_village = $request->permanent_village;
            $application->permanent_address = $request->permanent_address;

            $application->gender = $request->gender;
            $application->dob = $request->dob;
            $application->phone = $request->phone;
            $application->emergency_phone = $request->emergency_phone;

            $application->religion = $request->religion;
            $application->caste = $request->caste;
            $application->mother_tongue = $request->mother_tongue;
            $application->marital_status = $request->marital_status;
            $application->blood_group = $request->blood_group;
            $application->nationality = $request->nationality;
            $application->national_id = $request->national_id;
            $application->passport_no = $request->passport_no;

            $application->school_name = $request->school_name;
            $application->school_exam_id = $request->school_exam_id;
            $application->school_graduation_year = $request->school_graduation_year;
            $application->school_graduation_point = $request->school_graduation_point;
            $application->school_board = $request->school_board;
            $application->school_group = $request->school_group;
            $application->collage_name = $request->collage_name;
            $application->collage_exam_id = $request->collage_exam_id;
            $application->collage_graduation_year = $request->collage_graduation_year;
            $application->collage_graduation_point = $request->collage_graduation_point;
            $application->collage_board = $request->collage_board;
            $application->collage_group = $request->collage_group;

            $application->diploma_name = $request->diploma_name;
            $application->diploma_board = $request->diploma_board;
            $application->diploma_group = $request->diploma_group;
            $application->diploma_exam_id = $request->diploma_exam_id;
            $application->diploma_graduation_year = $request->diploma_graduation_year;
            $application->diploma_graduation_point = $request->diploma_graduation_point;

            $application->bachelor_name = $request->bachelor_name;
            $application->bachelor_board = $request->bachelor_board;
            $application->bachelor_group = $request->bachelor_group;
            $application->bachelor_exam_id = $request->bachelor_exam_id;
            $application->bachelor_graduation_year = $request->bachelor_graduation_year;
            $application->bachelor_graduation_point = $request->bachelor_graduation_point;

            $application->other_edu_name = $request->other_edu_name;
            $application->other_edu_board = $request->other_edu_board;
            $application->other_edu_group = $request->other_edu_group;
            $application->other_edu_exam_id = $request->other_edu_exam_id;
            $application->other_edu_graduation_year = $request->other_edu_graduation_year;
            $application->other_edu_graduation_point = $request->other_edu_graduation_point;

            $application->medical_condition = $request->medical_condition;
            $application->hostel_accommodation = $request->hostel_accommodation;
            $application->hostel_accommodation_text = $request->hostel_accommodation_text;
            $application->employment_status = $request->employment_status;
            $application->employment_text = $request->employment_text;
            $application->english_proficiency = $request->english_proficiency;
            $application->ielts_score = $request->ielts_score;
            $application->offense = $request->offense;
            $application->offense_text = $request->offense_text;
            $application->criminally_convicted = $request->criminally_convicted;
            $application->criminal_convicted_text = $request->criminal_convicted_text;

            $this->assignApplicationFilesToStudent($request, $data, $application);
            $application->status = '1';
            $application->created_by = Auth::guard('web')->user()->id;
            $application->save();

            // Attach Status
            $application->statuses()->attach($request->statuses);

            // Student Relatives
            if (is_array($request->relations)) {
                foreach ($request->relations as $key => $relation) {
                    if ($relation != '' && $relation != null) {
                        // Insert Data
                        $relation = new StudentRelative;
                        $relation->student_id = $application->id;
                        $relation->relation = $request->relations[$key];
                        $relation->name = $request->relative_names[$key];
                        $relation->occupation = $request->occupations[$key];
                        // $relation->email = $request->relative_emails[$key];
                        $relation->phone = $request->relative_phones[$key];
                        $relation->address = $request->addresses[$key];
                        $relation->save();
                    }
                }
            }

            // Student Documents
            if (is_array($request->documents)) {
                $documents = $request->file('documents');
                foreach ($documents as $key => $attach) {

                    // Valid extension check
                    $valid_extensions = ['JPG', 'JPEG', 'jpg', 'jpeg', 'png', 'gif', 'ico', 'svg', 'webp', 'pdf', 'doc', 'docx', 'txt', 'zip', 'rar', 'csv', 'xls', 'xlsx', 'ppt', 'pptx', 'mp3', 'avi', 'mp4', 'mpeg', '3gp', 'mov', 'ogg', 'mkv'];
                    $file_ext = $attach->getClientOriginalExtension();
                    if (in_array($file_ext, $valid_extensions, true)) {

                        // Upload Files
                        $filename = $attach->getClientOriginalName();
                        $extension = $attach->getClientOriginalExtension();
                        $fileNameToStore = str_replace([' ', '-', '&', '#', '$', '%', '^', ';', ':'], '_', $filename).'_'.time().'.'.$extension;

                        // Move file inside public/uploads/ directory
                        $attach->move('uploads/'.$this->path.'/', $fileNameToStore);

                        // Insert Data
                        $document = new Document;
                        $document->title = $request->titles[$key];
                        $document->attach = $fileNameToStore;
                        $document->save();

                        // Attach
                        $document->students()->attach($application->id);

                    }
                }
            }

            // // Student Enroll
            // $enroll = new StudentEnroll;
            // $enroll->student_id = $application->id;
            // $enroll->program_id = $request->program;
            // $enroll->session_id = $request->session;
            // $enroll->semester_id = $request->semester;
            // $enroll->section_id = $request->section;
            // $enroll->created_by = Auth::guard('web')->user()->id;
            // $enroll->save();

            // // Assign Subjects
            // $enrollSubject = EnrollSubject::where('program_id', $request->program)->where('semester_id', $request->semester)->where('section_id', $request->section)->first();

            // if (isset($enrollSubject)) {
            //     foreach ($enrollSubject->subjects as $subject) {
            //         // Attach Subject
            //         $enroll->subjects()->attach($subject->id);
            //     }
            // }

            // Application Status Update
            $data->status = '2';
            if (!$isPaidOnline) {
                $data->fee_amount = $request->collected_fees;
                $data->pay_status = 1; // Mark as paid manually
                $data->payment_method = 2; // Cash
            }
            $data->updated_by = Auth::guard('web')->user()->id;
            $data->save();

            DB::commit();

            Flasher::addSuccess(__('msg_created_successfully'), __('msg_success'));

            return redirect()->route($this->route.'.index');
        } catch (\Exception $e) {

            Flasher::addError(__('msg_created_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        $data['row'] = $application;

        return view($this->view.'.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        $data['provinces'] = Province::where('status', '1')
            ->orderBy('title', 'asc')->get();
        $data['present_districts'] = District::where('status', '1')
            ->where('province_id', $application->present_province)
            ->orderBy('title', 'asc')->get();
        $data['permanent_districts'] = District::where('status', '1')
            ->where('province_id', $application->permanent_province)
            ->orderBy('title', 'asc')->get();
        $data['statuses'] = StatusType::where('status', '1')->get();
        $data['batches'] = Batch::where('status', '1')->orderBy('id', 'desc')->get();
        $data['programs'] = Program::where('status', '1')->orderBy('title', 'asc')->get();

        $data['row'] = $application;

        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        //
        if ($application->status == 0) {
            $application->status = '1';
        } else {
            $application->status = '0';
        }
        $application->updated_by = Auth::guard('web')->user()->id;
        $application->save();

        Flasher::addSuccess(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        DB::beginTransaction();
        // Delete
        $this->deleteMultiMedia($this->path, $application, 'photo');
        $this->deleteMultiMedia($this->path, $application, 'signature');
        $this->deleteMultiMedia($this->path, $application, 'school_transcript');
        $this->deleteMultiMedia($this->path, $application, 'school_certificate');
        $this->deleteMultiMedia($this->path, $application, 'collage_transcript');
        $this->deleteMultiMedia($this->path, $application, 'collage_certificate');
        $this->deleteMultiMedia($this->path, $application, 'diploma_transcript');
        $this->deleteMultiMedia($this->path, $application, 'diploma_certificate');
        $this->deleteMultiMedia($this->path, $application, 'bachelor_transcript');
        $this->deleteMultiMedia($this->path, $application, 'bachelor_certificate');
        $this->deleteMultiMedia($this->path, $application, 'other_edu_transcript');
        $this->deleteMultiMedia($this->path, $application, 'other_edu_certificate');
        $this->deleteMultiMedia($this->path, $application, 'national_id_file');

        $application->delete();
        DB::commit();

        Flasher::addSuccess(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }

    private function applicationFileValidationRules(): array
    {
        $documentRule = 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512';

        return [
            'photo' => 'nullable|image|max:1024',
            'signature' => 'nullable|image|max:300',
            'school_transcript' => $documentRule,
            'school_certificate' => $documentRule,
            'collage_transcript' => $documentRule,
            'collage_certificate' => $documentRule,
            'diploma_transcript' => $documentRule,
            'diploma_certificate' => $documentRule,
            'bachelor_transcript' => $documentRule,
            'bachelor_certificate' => $documentRule,
            'other_edu_transcript' => $documentRule,
            'other_edu_certificate' => $documentRule,
            'national_id_file' => $documentRule,
        ];
    }

    private function assignApplicationFilesToStudent(Request $request, Application $source, Student $student): void
    {
        $documentFields = [
            'school_transcript',
            'school_certificate',
            'collage_transcript',
            'collage_certificate',
            'diploma_transcript',
            'diploma_certificate',
            'bachelor_transcript',
            'bachelor_certificate',
            'other_edu_transcript',
            'other_edu_certificate',
            'national_id_file',
        ];

        foreach ($documentFields as $field) {
            $student->{$field} = $request->hasFile($field)
                ? $this->uploadMedia($request, $field, $this->path)
                : $source->{$field};
        }

        $student->photo = $request->hasFile('photo')
            ? $this->uploadImage($request, 'photo', $this->path, 300, 300)
            : $source->photo;

        $student->signature = $request->hasFile('signature')
            ? $this->uploadImage($request, 'signature', $this->path, 300, 100)
            : $source->signature;
    }

    /**
     * Display a listing of paid application transactions.
     */
    public function transaction(Request $request)
    {
        $data['title'] = 'Application Fee Transactions';
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        if (! empty($request->program) || $request->program != null) {
            $data['selected_program'] = $program = $request->program;
        } else {
            $data['selected_program'] = '0';
        }

        if (! empty($request->start_date) || $request->start_date != null) {
            $data['selected_start_date'] = $start_date = $request->start_date;
        } else {
            $data['selected_start_date'] = $start_date = date('Y-m-d', strtotime(Carbon::now()->subYear()));
        }

        if (! empty($request->end_date) || $request->end_date != null) {
            $data['selected_end_date'] = $end_date = $request->end_date;
        } else {
            $data['selected_end_date'] = $end_date = date('Y-m-d', strtotime(Carbon::today()));
        }

        if (! empty($request->registration_no) || $request->registration_no != null) {
            $data['selected_registration_no'] = $registration_no = $request->registration_no;
        } else {
            $data['selected_registration_no'] = null;
        }

        $data['programs'] = Program::where('status', '1')->orderBy('title', 'asc')->get();

        $query = Application::where('pay_status', '1')
            ->whereNotNull('payment_method')
            ->whereDate('apply_date', '>=', $start_date)
            ->whereDate('apply_date', '<=', $end_date);

        if (! empty($request->program) && $request->program != '0') {
            $query->where('program_id', $program);
        }
        if (! empty($request->registration_no)) {
            $query->where('registration_no', 'LIKE', '%'.$registration_no.'%');
        }

        $data['rows'] = $query->orderBy('updated_at', 'desc')->get();

        return view($this->view.'.transaction', $data);
    }
}

