<?php

namespace App\Http\Controllers\Admin\Web;

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
        $data['return_url'] = url()->previous();

        // Key is unique, so always fetch by key to avoid losing inactive/legacy rows.
        $data['section'] = ContentSection::query()
                          ->where('key', $sectionKey)
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

        // Find by unique key so previously inactive rows remain editable.
        $section = ContentSection::query()->firstOrCreate(
            ['key' => $sectionKey],
            [
                'section_name' => $this->getSectionName($sectionKey),
                'status' => 1,
            ]
        );

        // Update the content
        $section->update([
            'language_id' => $languageId,
            'subtitle' => $request->subtitle,
            'title' => $request->title,
            'description' => $request->description,
            'status' => (int) $request->input('status', 0),
        ]);

        Flasher::addSuccess('Section updated successfully', 'Success');

        return redirect()->to($request->input('return_url', url()->previous()));
    }

    /**
     * Delete section content
     */
    public function destroy(Request $request, $sectionKey)
    {
        $section = ContentSection::query()
                      ->where('key', $sectionKey)
                      ->first();

        if ($section) {
            $section->update(['status' => 0]);
            Flasher::addSuccess('Section deactivated successfully', 'Success');
        } else {
            Flasher::addWarning('Section not found', 'Warning');
        }

        return redirect()->to($request->input('return_url', url()->previous()));
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
