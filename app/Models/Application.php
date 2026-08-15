<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'registration_no', 'batch_id', 'program_id', 'apply_date', 'first_name', 'last_name', 'father_name',
        'mother_name', 'father_occupation', 'mother_occupation', 'father_photo', 'mother_photo', 'country',
        'present_province', 'present_district', 'present_village', 'present_address', 'permanent_province',
        'permanent_district', 'permanent_village', 'permanent_address', 'gender', 'dob', 'email', 'phone',
        'emergency_phone', 'religion', 'caste', 'mother_tongue', 'marital_status', 'blood_group', 'nationality',
        'national_id', 'passport_no', 'school_name', 'school_exam_id', 'school_graduation_field',
        'school_graduation_year', 'school_graduation_point', 'school_transcript', 'school_certificate',
        'collage_name', 'collage_exam_id', 'collage_graduation_field', 'collage_graduation_year',
        'collage_graduation_point', 'collage_transcript', 'collage_certificate', 'photo', 'signature',
        'fee_amount', 'pay_status', 'payment_method', 'status', 'mail_sent', 'created_by', 'updated_by',
        'school_board', 'school_group', 'collage_board', 'collage_group',
        'diploma_name', 'diploma_board', 'diploma_group', 'diploma_exam_id', 'diploma_graduation_year', 'diploma_graduation_point', 'diploma_transcript', 'diploma_certificate',
        'bachelor_name', 'bachelor_board', 'bachelor_group', 'bachelor_exam_id', 'bachelor_graduation_year', 'bachelor_graduation_point', 'bachelor_transcript', 'bachelor_certificate',
        'other_edu_name', 'other_edu_board', 'other_edu_group', 'other_edu_exam_id', 'other_edu_graduation_year', 'other_edu_graduation_point', 'other_edu_transcript', 'other_edu_certificate',
        'medical_condition', 'hostel_accommodation', 'hostel_accommodation_text', 'employment_status', 'employment_text', 'english_proficiency', 'ielts_score', 'offense', 'offense_text', 'criminally_convicted', 'criminal_convicted_text',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function presentProvince()
    {
        return $this->belongsTo(Province::class, 'present_province');
    }

    public function presentDistrict()
    {
        return $this->belongsTo(District::class, 'present_district');
    }

    public function permanentProvince()
    {
        return $this->belongsTo(Province::class, 'permanent_province');
    }

    public function permanentDistrict()
    {
        return $this->belongsTo(District::class, 'permanent_district');
    }

    protected static function booted()
    {
        static::saved(function ($application) {
            if ($application->pay_status == 1 && !$application->mail_sent) {
                $application->mail_sent = 1;
                $application->saveQuietly();

                $application->sendNotificationEmails();
            }
        });
    }

    public function sendNotificationEmails()
    {
        $appSetting = \App\Models\ApplicationSetting::where('slug', 'admission')->where('status', '1')->first();
        if (!$appSetting) {
            return;
        }

        if ($appSetting->send_applicant_email && !empty($this->email)) {
            try {
                \Illuminate\Support\Facades\Mail::to($this->email)
                    ->send(new \App\Mail\ApplicantAdmissionMail($this));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Failed to send applicant admission email: ' . $e->getMessage());
            }
        }

        if ($appSetting->notify_university_email) {
            $mailSetting = \App\Models\MailSetting::where('status', '1')->first();
            $recipient = $mailSetting ? $mailSetting->sender_email : config('mail.from.address');

            if (!empty($recipient)) {
                try {
                    \Illuminate\Support\Facades\Mail::to($recipient)
                        ->send(new \App\Mail\UniversityNotificationMail($this));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Failed to send university admission notification: ' . $e->getMessage());
                }
            }
        }
    }
}
