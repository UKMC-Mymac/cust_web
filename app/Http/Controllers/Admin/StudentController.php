<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\StudentsImport;
use App\Mail\SendPassword;
use App\Models\Batch;
use App\Models\District;
use App\Models\Document;
use App\Models\EnrollSubject;
use App\Models\Faculty;
use App\Models\Fee;
use App\Models\Grade;
use App\Models\IdCardSetting;
use App\Models\MailSetting;
use App\Models\Program;
use App\Models\Province;
use App\Models\Section;
use App\Models\Semester;
use App\Models\Session;
use App\Models\StatusType;
use App\Models\Student;
use App\Models\StudentEnroll;
use App\Models\StudentRelative;
use App\Traits\FileUploader;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
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
        $this->title = trans_choice('module_student', 1);
        $this->route = 'admin.student';
        $this->view = 'admin.student';
        $this->path = 'student';
        $this->access = 'student';

        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index', 'show', 'status', 'sendPassword']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit', 'update', 'status']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
        $this->middleware('permission:'.$this->access.'-password-print', ['only' => ['printPassword', 'multiPrintPassword']]);
        $this->middleware('permission:'.$this->access.'-password-change', ['only' => ['passwordChange']]);
        $this->middleware('permission:'.$this->access.'-card', ['only' => ['card']]);
        $this->middleware('permission:'.$this->access.'-import', ['only' => ['import', 'importStore']]);
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

        if (! empty($request->faculty) || $request->faculty != null) {
            $data['selected_faculty'] = $faculty = $request->faculty;
        } else {
            $data['selected_faculty'] = $faculty = '0';
        }

        if (! empty($request->program) || $request->program != null) {
            $data['selected_program'] = $program = $request->program;
        } else {
            $data['selected_program'] = $program = '0';
        }

        if (! empty($request->session) || $request->session != null) {
            $data['selected_session'] = $session = $request->session;
        } else {
            $data['selected_session'] = $session = '0';
        }

        if (! empty($request->semester) || $request->semester != null) {
            $data['selected_semester'] = $semester = $request->semester;
        } else {
            $data['selected_semester'] = $semester = '0';
        }

        if (! empty($request->section) || $request->section != null) {
            $data['selected_section'] = $section = $request->section;
        } else {
            $data['selected_section'] = $section = '0';
        }

        if (! empty($request->status) || $request->status != null) {
            $data['selected_status'] = $status = $request->status;
        } else {
            $data['selected_status'] = '0';
        }

        if (! empty($request->student_id) || $request->student_id != null) {
            $data['selected_student_id'] = $student_id = $request->student_id;
        } else {
            $data['selected_student_id'] = null;
        }

        // Search Filter
        $data['faculties'] = Faculty::where('status', '1')->orderBy('title', 'asc')->get();
        $data['statuses'] = StatusType::where('status', '1')->orderBy('title', 'asc')->get();

        if (! empty($request->faculty) && $request->faculty != '0') {
            $data['programs'] = Program::where('faculty_id', $faculty)->where('status', '1')->orderBy('title', 'asc')->get();
        }

        if (! empty($request->program) && $request->program != '0') {
            $sessions = Session::where('status', 1);
            $sessions->with('programs')->whereHas('programs', function ($query) use ($program) {
                $query->where('program_id', $program);
            });
            $data['sessions'] = $sessions->orderBy('id', 'desc')->get();
        }

        if (! empty($request->program) && $request->program != '0') {
            $semesters = Semester::where('status', 1);
            $semesters->with('programs')->whereHas('programs', function ($query) use ($program) {
                $query->where('program_id', $program);
            });
            $data['semesters'] = $semesters->orderBy('id', 'asc')->get();
        }

        if (! empty($request->program) && $request->program != '0' && ! empty($request->semester) && $request->semester != '0') {
            $sections = Section::where('status', 1);
            $sections->with('semesterPrograms')->whereHas('semesterPrograms', function ($query) use ($program, $semester) {
                $query->where('program_id', $program);
                $query->where('semester_id', $semester);
            });
            $data['sections'] = $sections->orderBy('title', 'asc')->get();
        }

        if (isset($request->faculty) || isset($request->program) || isset($request->session) || isset($request->semester) || isset($request->section) || isset($request->status) || isset($request->student_id)) {
            // Student Filter
            $students = Student::where('status', '1');
            if ($faculty != 0) {
                $students->with('program')->whereHas('program', function ($query) use ($faculty) {
                    $query->where('faculty_id', $faculty);
                });
            }
            // $students->with('currentEnroll')->whereHas('currentEnroll', function ($query) use ($program, $session, $semester, $section){
            //     if($program != 0){
            //     $query->where('program_id', $program);
            //     }
            //     if($session != 0){
            //     $query->where('session_id', $session);
            //     }
            //     if($semester != 0){
            //     $query->where('semester_id', $semester);
            //     }
            //     if($section != 0){
            //     $query->where('section_id', $section);
            //     }
            // });
            if (! empty($request->status)) {
                $students->with('statuses')->whereHas('statuses', function ($query) use ($status) {
                    $query->where('status_type_id', $status);
                });
            }
            if (! empty($request->student_id)) {
                $students->where('student_id', 'LIKE', '%'.$student_id.'%');
            }
            $rows = $students->orderBy('student_id', 'desc')->get();

            // Array Sorting
            $data['rows'] = $rows->sortByDesc(function ($query) {

                return $query->student_id;

            })->all();
        }

        // $data['print'] = IdCardSetting::where('slug', 'student-card')->first();

        return view($this->view.'.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        $data['batches'] = Batch::where('status', '1')->orderBy('id', 'desc')->get();
        $data['statuses'] = StatusType::where('status', '1')->orderBy('title', 'asc')->get();
        $data['provinces'] = Province::where('status', '1')->orderBy('title', 'asc')->get();

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
        $request->validate([
            'student_id' => 'required|unique:students,student_id',
            'batch' => 'required',
            'program' => 'required',
            'session' => 'required',
            // 'semester' => 'required',
            // 'section' => 'required',
            'first_name' => 'required',
            'last_name' => 'nullable',
            'national_id_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required',
            'gender' => 'required',
            'dob' => 'required|date',
            'admission_date' => 'required|date',
            'photo' => 'nullable|image|max:1024',
            'signature' => 'nullable|image|max:300',
            'school_transcript' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'school_certificate' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'collage_transcript' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'collage_certificate' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'diploma_transcript' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'diploma_certificate' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'bachelor_transcript' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'bachelor_certificate' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'other_edu_transcript' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'other_edu_certificate' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
        ]);

        // Random Password
        $password = str_random(8);

        // Insert Data
        try {
            DB::beginTransaction();

            $student = new Student;
            $student->student_id = $request->student_id;
            $student->batch_id = $request->batch;
            $student->program_id = $request->program;
            $student->admission_date = $request->admission_date;

            $student->first_name = $request->first_name;
            $student->last_name = $request->last_name ?? '';
            $student->father_name = $request->father_name;
            $student->mother_name = $request->mother_name;
            $student->father_occupation = $request->father_occupation;
            $student->mother_occupation = $request->mother_occupation;
            $student->email = $request->email;
            $student->password = Hash::make($password);
            $student->password_text = Crypt::encryptString($password);

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
            $student->created_by = Auth::guard('web')->user()->id;
            $student->save();

            // Attach Status
            $student->statuses()->attach($request->statuses);

            // Student Relatives
            if (is_array($request->relations)) {
                foreach ($request->relations as $key => $relation) {
                    if ($relation != '' && $relation != null) {
                        // Insert Data
                        $relation = new StudentRelative;
                        $relation->student_id = $student->id;
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
                        $document->students()->attach($student->id);

                    }
                }
            }

            //  Student Enroll
            $enroll = new StudentEnroll;
            $enroll->student_id = $student->id;
            $enroll->session_id = $request->session;
            // $enroll->semester_id = $request->semester;
            $enroll->program_id = $request->program;
            // $enroll->section_id = $request->section;
            $enroll->created_by = Auth::guard('web')->user()->id;
            $enroll->save();

            // Assign Subjects
            $enrollSubject = EnrollSubject::where('program_id', $request->program)->where('semester_id', $request->semester)->where('section_id', $request->section)->first();

            if (isset($enrollSubject)) {
                foreach ($enrollSubject->subjects as $subject) {
                    // Attach Subject
                    $enroll->subjects()->attach($subject->id);
                }
            }

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
    public function show(Student $student)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        $data['row'] = $student;

        $data['fees'] = Fee::with('studentEnroll')->whereHas('studentEnroll', function ($query) use ($student) {
            $query->where('student_id', $student->id);
        })
            ->orderBy('id', 'desc')->get();

        $data['grades'] = Grade::where('status', '1')->orderBy('min_mark', 'desc')->get();

        return view($this->view.'.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        $data['provinces'] = Province::where('status', '1')
            ->orderBy('title', 'asc')->get();
        $data['present_districts'] = District::where('status', '1')
            ->where('province_id', $student->present_province)
            ->orderBy('title', 'asc')->get();
        $data['permanent_districts'] = District::where('status', '1')
            ->where('province_id', $student->permanent_province)
            ->orderBy('title', 'asc')->get();
        $data['statuses'] = StatusType::where('status', '1')->get();
        $data['batches'] = Batch::where('status', '1')->orderBy('id', 'desc')->get();
        $data['sessions'] = Session::where('status', '1')->orderBy('id', 'desc')->get();
        $data['curr_enroll'] = Student::enroll($student->id);

        $data['row'] = $student;

        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'student_id' => 'required|unique:students,student_id,'.$student->id,
            'batch' => 'required',
            'session' => 'required',
            'first_name' => 'required',
            'last_name' => 'nullable',
            'national_id_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'email' => 'required|email|unique:students,email,'.$student->id,
            'phone' => 'required',
            'gender' => 'required',
            'dob' => 'required|date',
            'admission_date' => 'required|date',
            'photo' => 'nullable|image|max:1024',
            'signature' => 'nullable|image|max:300',
            'school_transcript' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'school_certificate' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'collage_transcript' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'collage_certificate' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'diploma_transcript' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'diploma_certificate' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'bachelor_transcript' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'bachelor_certificate' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'other_edu_transcript' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
            'other_edu_certificate' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:512',
        ]);

        // Update Data
        try {
            DB::beginTransaction();

            $student->student_id = $request->student_id;
            $student->batch_id = $request->batch;
            $student->admission_date = $request->admission_date;

            $student->first_name = $request->first_name;
            $student->last_name = $request->last_name ?? '';
            $student->father_name = $request->father_name;
            $student->mother_name = $request->mother_name;
            $student->father_occupation = $request->father_occupation;
            $student->mother_occupation = $request->mother_occupation;
            $student->email = $request->email;

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

            $student->school_transcript = $this->updateMultiMedia($request, 'school_transcript', $this->path, $student, 'school_transcript');
            $student->school_certificate = $this->updateMultiMedia($request, 'school_certificate', $this->path, $student, 'school_certificate');
            $student->collage_transcript = $this->updateMultiMedia($request, 'collage_transcript', $this->path, $student, 'collage_transcript');
            $student->collage_certificate = $this->updateMultiMedia($request, 'collage_certificate', $this->path, $student, 'collage_certificate');
            $student->diploma_transcript = $this->updateMultiMedia($request, 'diploma_transcript', $this->path, $student, 'diploma_transcript');
            $student->diploma_certificate = $this->updateMultiMedia($request, 'diploma_certificate', $this->path, $student, 'diploma_certificate');
            $student->bachelor_transcript = $this->updateMultiMedia($request, 'bachelor_transcript', $this->path, $student, 'bachelor_transcript');
            $student->bachelor_certificate = $this->updateMultiMedia($request, 'bachelor_certificate', $this->path, $student, 'bachelor_certificate');
            $student->other_edu_transcript = $this->updateMultiMedia($request, 'other_edu_transcript', $this->path, $student, 'other_edu_transcript');
            $student->other_edu_certificate = $this->updateMultiMedia($request, 'other_edu_certificate', $this->path, $student, 'other_edu_certificate');
            $student->national_id_file = $this->updateMultiMedia($request, 'national_id_file', $this->path, $student, 'national_id_file');

            $student->photo = $this->updateImage($request, 'photo', $this->path, 300, 300, $student, 'photo');
            $student->signature = $this->updateImage($request, 'signature', $this->path, 300, 100, $student, 'signature');
            $student->updated_by = Auth::guard('web')->user()->id;
            $student->save();

            // Update Enrollment Session
            $enroll = StudentEnroll::where('student_id', $student->id)->where('status', '1')->first();
            if ($enroll) {
                $enroll->session_id = $request->session;
                $enroll->save();
            } else {
                $enroll = new StudentEnroll;
                $enroll->student_id = $student->id;
                $enroll->session_id = $request->session;
                $enroll->program_id = $student->program_id;

                // $default_semester = Semester::where('status', '1')->first();
                // $default_section = Section::where('status', '1')->first();

                // $enroll->semester_id = $default_semester ? $default_semester->id : 1;
                // $enroll->section_id = $default_section ? $default_section->id : 1;
                $enroll->created_by = Auth::guard('web')->user()->id;
                $enroll->save();
            }

            // Update Status
            $student->statuses()->sync($request->statuses ?? []);

            // Remove Old Relatives
            StudentRelative::where('student_id', $student->id)->delete();
            // Student Relatives
            if (is_array($request->relations)) {
                foreach ($request->relations as $key => $relation) {
                    if ($relation != '' && $relation != null) {
                        // Insert Data
                        $relation = new StudentRelative;
                        $relation->student_id = $student->id;
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
                        $document->students()->sync($student->id);

                    }
                }
            }

            DB::commit();

            Flasher::addSuccess(__('msg_updated_successfully'), __('msg_success'));

            return redirect()->route($this->route.'.index');
        } catch (\Throwable $e) {

            Flasher::addError(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        DB::beginTransaction();
        // Delete
        $this->deleteMultiMedia($this->path, $student, 'photo');
        $this->deleteMultiMedia($this->path, $student, 'signature');
        $this->deleteMultiMedia($this->path, $student, 'school_transcript');
        $this->deleteMultiMedia($this->path, $student, 'school_certificate');
        $this->deleteMultiMedia($this->path, $student, 'collage_transcript');
        $this->deleteMultiMedia($this->path, $student, 'collage_certificate');
        $this->deleteMultiMedia($this->path, $student, 'diploma_transcript');
        $this->deleteMultiMedia($this->path, $student, 'diploma_certificate');
        $this->deleteMultiMedia($this->path, $student, 'bachelor_transcript');
        $this->deleteMultiMedia($this->path, $student, 'bachelor_certificate');
        $this->deleteMultiMedia($this->path, $student, 'other_edu_transcript');
        $this->deleteMultiMedia($this->path, $student, 'other_edu_certificate');
        $this->deleteMultiMedia($this->path, $student, 'national_id_file');

        // Detach
        $student->relatives()->delete();
        $student->statuses()->detach();
        $student->documents()->detach();
        $student->contents()->detach();
        $student->notices()->detach();
        $student->member()->delete();
        $student->hostelRoom()->delete();
        $student->transport()->delete();
        $student->notes()->delete();

        $student->delete();
        DB::commit();

        Flasher::addSuccess(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function status($id)
    {
        // Set Status
        $user = Student::where('id', $id)->firstOrFail();

        if ($user->login == 1) {
            $user->login = 0;
            $user->save();
        } else {
            $user->login = 1;
            $user->save();
        }

        Flasher::addSuccess(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendPassword($id)
    {
        //
        $user = Student::where('id', $id)->firstOrFail();

        $mail = MailSetting::where('status', '1')->first();

        if (isset($mail->sender_email) && isset($mail->sender_name)) {

            $sendTo = $user->email;
            $receiver = $user->first_name.' '.$user->last_name;

            // Passing data to email template
            $data['name'] = $user->first_name.' '.$user->first_name;
            $data['student_id'] = $user->student_id;
            $data['email'] = $user->email;
            $data['password'] = Crypt::decryptString($user->password_text);

            // Mail Information
            $data['subject'] = __('msg_your_login_credentials');
            $data['from'] = $mail->sender_email;
            $data['sender'] = $mail->sender_name;

            // Send Mail
            Mail::to($sendTo, $receiver)->send(new SendPassword($data));

            Flasher::addSuccess(__('msg_sent_successfully'), __('msg_success'));
        } else {
            Flasher::addSuccess(__('msg_receiver_not_found'), __('msg_success'));
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function printPassword($id)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;

        $data['rows'] = Student::where('id', $id)->get();

        return view($this->view.'.password-print', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function multiPrintPassword(Request $request)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;

        $students = explode(',', $request->students);

        // View
        $data['rows'] = Student::whereIn('id', $students)->orderBy('id', 'asc')->get();

        return view($this->view.'.password-print', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function passwordChange(Request $request)
    {
        // Field Validation
        $request->validate([
            'student_id' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        // Update Data
        $student = Student::findOrFail($request->student_id);
        $student->password = Hash::make($request->password);
        $student->password_text = Crypt::encryptString($request->password);
        $student->save();

        Flasher::addSuccess(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function card($id)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        $data['rows'] = Student::where('id', $id)->orderBy('student_id', 'asc')->get();

        $data['print'] = IdCardSetting::where('slug', 'student-card')->firstOrFail();

        return view('admin.id-card.print', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['access'] = $this->access;

        //
        $data['batches'] = Batch::where('status', '1')
            ->orderBy('id', 'desc')->get();

        return view($this->view.'.import', $data);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function importStore(Request $request)
    {
        // Field Validation
        $request->validate([
            'batch' => 'required',
            'program' => 'required',
            'session' => 'required',
            'semester' => 'required',
            'section' => 'required',
            'import' => 'required|file|mimes:xlsx',
        ]);

        // Passing Data
        $data['batch'] = $request->batch;
        $data['program'] = $request->program;
        $data['session'] = $request->session;
        $data['semester'] = $request->semester;
        $data['section'] = $request->section;

        Excel::import(new StudentsImport($data), $request->file('import'));

        Flasher::addSuccess(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
