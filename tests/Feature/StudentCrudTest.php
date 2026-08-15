<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use App\User;
use App\Models\Student;
use App\Models\Batch;
use App\Models\Program;
use App\Models\Session;
use App\Models\Semester;
use App\Models\Section;

class StudentCrudTest extends TestCase
{
    use DatabaseTransactions;

    protected function getUploadedPath($filename)
    {
        if (empty($filename)) {
            return '';
        }
        $publicPath = public_path('uploads/student/' . $filename);
        if (file_exists($publicPath)) {
            return $publicPath;
        }
        return base_path('uploads/student/' . $filename);
    }

    public function testStudentCrud()
    {
        // 1. Get or create a User
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'is_admin' => 1,
                'status' => 1,
            ]);
        }

        // 2. Get or create Batch, Program, Session, Semester, Section
        $batch = Batch::first() ?? Batch::create(['title' => 'Test Batch', 'status' => 1]);
        $program = Program::first() ?? Program::create(['title' => 'Test Program', 'status' => 1]);
        $session = Session::first() ?? Session::create(['title' => 'Test Session', 'status' => 1]);
        $semester = Semester::first() ?? Semester::create(['title' => 'Test Semester', 'status' => 1]);
        $section = Section::first() ?? Section::create(['title' => 'Test Section', 'status' => 1]);

        // Create dummy files for transcripts/certificates
        $diplomaTranscript = UploadedFile::fake()->create('diploma_transcript.pdf', 100);
        $diplomaCertificate = UploadedFile::fake()->create('diploma_certificate.pdf', 100);
        $bachelorTranscript = UploadedFile::fake()->create('bachelor_transcript.pdf', 100);
        $bachelorCertificate = UploadedFile::fake()->create('bachelor_certificate.pdf', 100);
        $otherEduTranscript = UploadedFile::fake()->create('other_transcript.pdf', 100);
        $otherEduCertificate = UploadedFile::fake()->create('other_certificate.pdf', 100);
        $photo = UploadedFile::fake()->image('student_photo.jpg', 300, 300);
        $signature = UploadedFile::fake()->image('signature.jpg', 300, 100);

        // Store Student request
        $studentData = [
            'student_id' => 'STU' . time() . rand(10, 99),
            'batch' => $batch->id,
            'program' => $program->id,
            'session' => $session->id,
            'semester' => $semester->id,
            'section' => $section->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'student_' . time() . rand(10, 99) . '@example.com',
            'phone' => '1234567890',
            'gender' => 1,
            'dob' => '2000-01-01',
            'admission_date' => '2026-06-10',
            'school_name' => 'High School',
            'school_exam_id' => '12345',
            'school_graduation_year' => '2018',
            'school_graduation_point' => '3.8',
            'school_board' => 'Dhaka',
            'school_group' => 'Science',
            'collage_name' => 'College',
            'collage_exam_id' => '54321',
            'collage_graduation_year' => '2020',
            'collage_graduation_point' => '4.0',
            'collage_board' => 'Dhaka',
            'collage_group' => 'Science',

            // Advanced Fields
            'diploma_name' => 'Diploma Poly',
            'diploma_board' => 'BTEB',
            'diploma_group' => 'Computer Science',
            'diploma_exam_id' => '998877',
            'diploma_graduation_year' => '2022',
            'diploma_graduation_point' => '3.90',

            'bachelor_name' => 'Bachelor University',
            'bachelor_board' => 'National University',
            'bachelor_group' => 'SWE',
            'bachelor_exam_id' => '776655',
            'bachelor_graduation_year' => '2025',
            'bachelor_graduation_point' => '3.85',

            'other_edu_name' => 'Other Inst',
            'other_edu_board' => 'Other Board',
            'other_edu_group' => 'Other Group',
            'other_edu_exam_id' => '554433',
            'other_edu_graduation_year' => '2026',
            'other_edu_graduation_point' => '4.00',

            'medical_condition' => 'None',
            'hostel_accommodation' => 'Yes',
            'hostel_accommodation_text' => 'Need single room',
            'employment_status' => 'Part-time',
            'employment_text' => 'Works at tech shop',
            'english_proficiency' => 'IELTS',
            'ielts_score' => '7.5',
            'offense' => 'Yes',
            'offense_text' => 'Late submission warning',
            'criminally_convicted' => 'No',
            'criminal_convicted_text' => '',

            // Files
            'diploma_transcript' => $diplomaTranscript,
            'diploma_certificate' => $diplomaCertificate,
            'bachelor_transcript' => $bachelorTranscript,
            'bachelor_certificate' => $bachelorCertificate,
            'other_edu_transcript' => $otherEduTranscript,
            'other_edu_certificate' => $otherEduCertificate,
            'photo' => $photo,
            'signature' => $signature,
        ];

        // 3. Test Student Creation (Store)
        $response = $this->actingAs($user, 'web')->post(route('admin.student.store'), $studentData);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        // 4. Assert Student exists in database with correct advanced fields
        $student = Student::where('email', $studentData['email'])->first();
        $this->assertNotNull($student);
        $this->assertEquals('Diploma Poly', $student->diploma_name);
        $this->assertEquals('BTEB', $student->diploma_board);
        $this->assertEquals('Computer Science', $student->diploma_group);
        $this->assertEquals('998877', $student->diploma_exam_id);
        $this->assertEquals('2022', $student->diploma_graduation_year);
        $this->assertEquals('3.90', $student->diploma_graduation_point);

        $this->assertEquals('Bachelor University', $student->bachelor_name);
        $this->assertEquals('SWE', $student->bachelor_group);

        $this->assertEquals('None', $student->medical_condition);
        $this->assertEquals('Yes', $student->hostel_accommodation);
        $this->assertEquals('Need single room', $student->hostel_accommodation_text);
        $this->assertEquals('Part-time', $student->employment_status);
        $this->assertEquals('Works at tech shop', $student->employment_text);
        $this->assertEquals('IELTS', $student->english_proficiency);
        $this->assertEquals('7.5', $student->ielts_score);
        $this->assertEquals('Yes', $student->offense);
        $this->assertEquals('Late submission warning', $student->offense_text);
        $this->assertEquals('No', $student->criminally_convicted);

        // Verify that the files were uploaded
        $this->assertNotEmpty($student->diploma_transcript);
        $this->assertFileExists($this->getUploadedPath($student->diploma_transcript));
        
        $diplomaTranscriptPath = $this->getUploadedPath($student->diploma_transcript);
        $diplomaCertificatePath = $this->getUploadedPath($student->diploma_certificate);
        $bachelorTranscriptPath = $this->getUploadedPath($student->bachelor_transcript);
        $bachelorCertificatePath = $this->getUploadedPath($student->bachelor_certificate);
        $otherTranscriptPath = $this->getUploadedPath($student->other_edu_transcript);
        $otherCertificatePath = $this->getUploadedPath($student->other_edu_certificate);
        $photoPath = $this->getUploadedPath($student->photo);
        $signaturePath = $this->getUploadedPath($student->signature);

        // 5. Test Student Edit/Update
        $newDiplomaTranscript = UploadedFile::fake()->create('diploma_transcript_new.pdf', 100);
        $updateData = array_merge($studentData, [
            '_method' => 'PUT',
            'first_name' => 'Johnny',
            'diploma_name' => 'Diploma Poly Updated',
            'diploma_transcript' => $newDiplomaTranscript,
        ]);
        unset($updateData['diploma_certificate']);
        unset($updateData['bachelor_transcript']);
        unset($updateData['bachelor_certificate']);
        unset($updateData['other_edu_transcript']);
        unset($updateData['other_edu_certificate']);
        unset($updateData['photo']);
        unset($updateData['signature']);
        unset($updateData['school_transcript']);
        unset($updateData['school_certificate']);
        unset($updateData['collage_transcript']);
        unset($updateData['collage_certificate']);

        // Submit via POST with simulated PUT method
        $response = $this->actingAs($user, 'web')->post(route('admin.student.update', $student->id), $updateData);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $student->refresh();
        $this->assertEquals('Johnny', $student->first_name);
        $this->assertEquals('Diploma Poly Updated', $student->diploma_name);
        
        // The old diploma transcript file should be deleted and replaced
        $this->assertFileDoesNotExist($diplomaTranscriptPath);
        $this->assertFileExists($this->getUploadedPath($student->diploma_transcript));
        $newDiplomaTranscriptPath = $this->getUploadedPath($student->diploma_transcript);

        // 6. Test Student Show Page renders successfully and has the added fields visible
        $response = $this->actingAs($user, 'web')->get(route('admin.student.show', $student->id));
        $response->assertStatus(200);
        $response->assertSee('Diploma Poly Updated');
        $response->assertSee('Bachelor University');
        $response->assertSee('Medical Condition');
        $response->assertSee('Employment Status');

        // 7. Test Student Deletion (Destroy)
        $response = $this->actingAs($user, 'web')->delete(route('admin.student.destroy', $student->id));
        $response->assertRedirect();

        // Check student is deleted
        $this->assertNull(Student::find($student->id));

        // Check that all files are deleted from storage
        $this->assertFileDoesNotExist($newDiplomaTranscriptPath);
        $this->assertFileDoesNotExist($diplomaCertificatePath);
        $this->assertFileDoesNotExist($bachelorTranscriptPath);
        $this->assertFileDoesNotExist($bachelorCertificatePath);
        $this->assertFileDoesNotExist($otherTranscriptPath);
        $this->assertFileDoesNotExist($otherCertificatePath);
        $this->assertFileDoesNotExist($photoPath);
        $this->assertFileDoesNotExist($signaturePath);
    }
}
