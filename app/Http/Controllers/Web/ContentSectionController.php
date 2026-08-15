<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Web\ContentSection;
use App\Models\Language;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;

class ContentSectionController extends Controller
{
    /**
     * Display section heading form and list for a specific section key
     */
    public function manage($sectionKey)
    {
        $data['title'] = 'Content Section';
        $data['key'] = $sectionKey;
        $data['section_name'] = $this->getSectionName($sectionKey);

        // Get the section record for this key (language-specific)
        $languageId = Language::version()->id ?? null;
        /** @var ContentSection|null $section */
        $data['section'] = ContentSection::query()
                                          ->where('key', $sectionKey)
                                          ->where('language_id', $languageId)
                                          ->first();

        return view('admin.web.content-section.manage', $data);
    }

    /**
     * Store or update section content
     */
    public function store(Request $request, $sectionKey)
    {
        $request->validate([
            'subtitle' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $languageId = Language::version()->id ?? null;
        
        // Find or create section record
        $section = ContentSection::firstOrCreate(
            ['key' => $sectionKey, 'language_id' => $languageId],
            [
                'section_name' => $this->getSectionName($sectionKey),
                'status' => 1,
            ]
        );

        // Update the content
        $section->update([
            'subtitle' => $request->subtitle,
            'title' => $request->title,
            'description' => $request->description,
            'status' => (int) $request->input('status', 1),
        ]);

        Flasher::addSuccess('Section updated successfully', 'Success');

        return redirect()->back();
    }

    /**
     * Delete section content
     */
    public function destroy($sectionKey)
    {
        $languageId = Language::version()->id ?? null;
        
        ContentSection::query()
                      ->where('key', $sectionKey)
                      ->where('language_id', $languageId)
                      ->delete();

        Flasher::addSuccess('Section deleted successfully', 'Success');

        return redirect()->back();
    }

    /**
     * Get human-readable section name based on key
     */
    private function getSectionName($key)
    {
        $names = [
            'feature' => 'Feature/Academics Section',
            'why_choose_us' => 'Why Choose Us Section',
            'testimonials' => 'Testimonials Section',
            'apply' => 'Application Section',
            'clubs' => 'Clubs Section',
            'hero' => 'Hero Section',
        ];

        return $names[$key] ?? ucfirst(str_replace('_', ' ', $key)) . ' Section';
    }
}