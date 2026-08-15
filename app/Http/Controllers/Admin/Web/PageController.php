<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Web\Page;
use App\Traits\FileUploader;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PageController extends Controller
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
        $this->title = trans_choice('module_page', 1);
        $this->route = 'admin.page';
        $this->view = 'admin.web.page';
        $this->path = 'page';
        $this->access = 'page';

        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        $query = Page::where('language_id', '=', Language::version()->id);

        if (!empty($request->title)) {
            $query->where('title', 'like', '%'.$request->title.'%');
            $data['selected_title'] = $request->title;
        } else {
            $data['selected_title'] = null;
        }

        $data['rows'] = $query->orderby('id', 'asc')->paginate(10);

        return view($this->view.'.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['access'] = $this->access;
        $data['pages'] = Page::query()
            ->where('language_id', '=', Language::version()->id, 'and')
            ->where('status', '=', 1, 'and')
            ->orderBy('title', 'asc')
            ->get();
        $data['builderSections'] = [];
        $data['pageNavItems'] = [];
        $data['pageNavPosition'] = old('page_nav_position', 'right');
        $data['layoutMode'] = old('layout_mode', 'editor');

        return view($this->view.'.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $layoutMode = $request->input('layout_mode', 'editor');

        // Field Validation
        $rules = [
            'title' => 'required|unique:pages,title',
            'display_text' => 'nullable|string|max:255',
            'layout_mode' => 'required|in:editor,builder',
        ];

        if ($layoutMode === 'builder') {
            $rules['builder_sections'] = 'required|json';
            $rules['builder_images.*'] = 'nullable|image';
            $rules['page_nav_items'] = 'nullable|json';
            $rules['page_nav_position'] = 'nullable|in:left,right';
        } else {
            $rules['content_html'] = 'required';
        }

        $request->validate($rules);

        $builderSections = $layoutMode === 'builder' ? $this->prepareBuilderSections($request) : [];

        if ($layoutMode === 'builder' && empty($builderSections)) {
            return redirect()->back()
                ->withErrors(['builder_sections' => 'Add at least one section for the page builder.'])
                ->withInput();
        }

        // Data Insert
        $page = new Page;
        $page->language_id = Language::version()->id;
        $page->title = $request->title;
        $page->display_text = $request->display_text;
        $page->slug = Str::slug($request->title, '-');
        $page->layout_mode = $layoutMode;
        $page->content_html = $layoutMode === 'builder' ? null : $this->normalizeEditorImagePaths($request->content_html);
        $page->builder_sections = $layoutMode === 'builder' ? $builderSections : null;
        $page->page_nav_items = $layoutMode === 'builder' ? json_decode((string) $request->input('page_nav_items', '[]'), true) : null;
        $page->page_nav_position = $layoutMode === 'builder' ? $request->input('page_nav_position', 'right') : null;
        $page->description = $layoutMode === 'builder'
            ? strip_tags($this->flattenBuilderSections($builderSections))
            : strip_tags($page->content_html ?? $request->description);
        // Thumbnail handling is temporarily disabled in admin form.
        // $page->attach = $this->uploadImage($request, 'attach', $this->path, 1200, 600);
        $page->save();

        Flasher::addSuccess(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['access'] = $this->access;

        $data['row'] = $page;
        $data['pages'] = Page::query()
            ->where('language_id', '=', Language::version()->id, 'and')
            ->where('status', '=', 1, 'and')
            ->orderBy('title', 'asc')
            ->get();
        $data['builderSections'] = is_array($page->builder_sections) ? $page->builder_sections : [];
        $data['pageNavItems'] = is_array($page->page_nav_items) ? $page->page_nav_items : [];
        $data['pageNavPosition'] = old('page_nav_position', $page->page_nav_position ?? 'right');
        $data['layoutMode'] = old('layout_mode', $page->layout_mode ?? 'editor');

        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $layoutMode = $request->input('layout_mode', 'editor');

        // Field Validation
        $rules = [
            'title' => 'required|unique:pages,title,'.$page->id,
            'display_text' => 'nullable|string|max:255',
            'layout_mode' => 'required|in:editor,builder',
        ];

        if ($layoutMode === 'builder') {
            $rules['builder_sections'] = 'required|json';
            $rules['builder_images.*'] = 'nullable|image';
            $rules['page_nav_items'] = 'nullable|json';
            $rules['page_nav_position'] = 'nullable|in:left,right';
        } else {
            $rules['content_html'] = 'required';
        }

        $request->validate($rules);

        $oldContentHtml = $page->content_html;
        $oldSections = is_array($page->builder_sections) ? $page->builder_sections : [];
        $builderSections = $layoutMode === 'builder' ? $this->prepareBuilderSections($request, $oldSections) : [];

        if ($layoutMode === 'builder' && empty($builderSections)) {
            return redirect()->back()
                ->withErrors(['builder_sections' => 'Add at least one section for the page builder.'])
                ->withInput();
        }

        // Data Update
        $page->title = $request->title;
        $page->display_text = $request->display_text;
        $page->slug = Str::slug($request->title, '-');
        $page->layout_mode = $layoutMode;
        $page->content_html = $layoutMode === 'builder' ? null : $this->normalizeEditorImagePaths($request->content_html);
        $page->builder_sections = $layoutMode === 'builder' ? $builderSections : null;
        $page->page_nav_items = $layoutMode === 'builder' ? json_decode((string) $request->input('page_nav_items', '[]'), true) : null;
        $page->page_nav_position = $layoutMode === 'builder' ? $request->input('page_nav_position', 'right') : null;
        $page->description = $layoutMode === 'builder'
            ? strip_tags($this->flattenBuilderSections($builderSections))
            : strip_tags($page->content_html ?? $request->description);
        // Thumbnail handling is temporarily disabled in admin form.
        // $page->attach = $this->updateImage($request, 'attach', $this->path, 1200, 600, $page, 'attach');
        $page->status = $request->status;
        $page->save();

        $this->removeUnusedBuilderImages($oldSections, $builderSections);

        // Delete WYSIWYG editor files that are no longer referenced in the HTML content
        $oldEditorFiles = $this->extractEditorFiles($oldContentHtml);
        $newEditorFiles = $this->extractEditorFiles($page->content_html);

        foreach (array_diff($oldEditorFiles, $newEditorFiles) as $file) {
            $path = public_path('uploads/page/'.$file);
            if (File::isFile($path)) {
                File::delete($path);
            }
        }

        Flasher::addSuccess(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Normalize TinyMCE-generated relative uploads paths.
     */
    private function normalizeEditorImagePaths(?string $content): ?string
    {
        if (empty($content)) {
            return $content;
        }

        return preg_replace('/(src\s*=\s*["\'])(?:\.\.\/)+(uploads\/)/i', '$1/$2', $content);
    }

    /**
     * Normalize builder sections and upload any replacement images.
     */
    private function prepareBuilderSections(Request $request, array $existingSections = []): array
    {
        $rawSections = json_decode((string) $request->input('builder_sections', '[]'), true);

        if (! is_array($rawSections)) {
            return [];
        }

        $existingByKey = [];
        foreach ($existingSections as $section) {
            if (! empty($section['key'])) {
                $existingByKey[$section['key']] = $section;
            }
        }

        $uploadedImages = $request->file('builder_images', []);
        $normalizedSections = [];

        foreach ($rawSections as $section) {
            if (! is_array($section)) {
                continue;
            }

            $key = (string) ($section['key'] ?? uniqid('section_', false));
            $existingSection = $existingByKey[$key] ?? [];
            $imagePath = $section['image'] ?? ($existingSection['image'] ?? null);

            if (! empty($uploadedImages[$key] ?? null)) {
                $imagePath = $this->storeBuilderImage($uploadedImages[$key]);
            }

            $normalizedSections[] = [
                'key' => $key,
                'title' => trim((string) ($section['title'] ?? '')),
                'subtitle' => trim((string) ($section['subtitle'] ?? '')),
                'content' => (string) ($section['content'] ?? ''),
                'image' => $imagePath,
                'image_position' => in_array(($section['image_position'] ?? 'right'), ['left', 'right'], true) ? $section['image_position'] : 'right',
                'image_alt' => trim((string) ($section['image_alt'] ?? '')),
            ];
        }

        return $normalizedSections;
    }

    /**
     * Store a single uploaded page builder image.
     */
    private function storeBuilderImage($file): ?string
    {
        if (! $file) {
            return null;
        }

        $validExtensions = ['JPG', 'JPEG', 'jpg', 'jpeg', 'png', 'gif', 'ico', 'svg', 'webp'];
        $extension = $file->getClientOriginalExtension();
        if (! in_array($extension, $validExtensions, true)) {
            return null;
        }

        $directory = public_path('uploads/page-builder/');
        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0777, true, true);
        }

        $filenameWithExt = $file->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $fileNameToStore = str_replace([' ', '-', '&', '#', '$', '%', '^', ';', ':'], '_', $filename).'_'.time().'.'.$extension;
        $file->move($directory, $fileNameToStore);

        return $fileNameToStore;
    }

    /**
     * Build a compact plain-text description from the builder sections.
     */
    private function flattenBuilderSections(array $sections): string
    {
        return collect($sections)->map(function ($section) {
            $chunks = [
                $section['title'] ?? '',
                $section['subtitle'] ?? '',
                $section['content'] ?? '',
                collect($section['nav_items'] ?? [])->pluck('title')->implode(' '),
            ];

            return trim(implode(' ', $chunks));
        })->implode(' ');
    }

    /**
     * Normalize navigation items inside a section.
     */
    private function normalizeSectionNavItems(array $navItems): array
    {
        return collect($navItems)->map(function ($item) {
            if (! is_array($item)) {
                return null;
            }

            return [
                'title' => trim((string) ($item['title'] ?? '')),
                'page_id' => (int) ($item['page_id'] ?? 0),
                'active' => (string) ($item['active'] ?? '1') === '1' ? '1' : '0',
            ];
        })->filter(function ($item) {
            return ! empty($item['title']) || ! empty($item['page_id']);
        })->values()->all();
    }

    /**
     * Delete builder images that are no longer referenced.
     */
    private function removeUnusedBuilderImages(array $oldSections, array $newSections): void
    {
        $oldImages = $this->extractBuilderImages($oldSections);
        $newImages = $this->extractBuilderImages($newSections);

        foreach (array_diff($oldImages, $newImages) as $image) {
            $path = public_path('uploads/page-builder/'.$image);
            if (File::isFile($path)) {
                File::delete($path);
            }
        }
    }

    /**
     * Extract image filenames from a section list.
     */
    private function extractBuilderImages(array $sections): array
    {
        return collect($sections)
            ->pluck('image')
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    /**
     * Extract WYSIWYG editor filenames from content HTML.
     */
    private function extractEditorFiles(?string $content): array
    {
        if (empty($content)) {
            return [];
        }

        // Match any file path under uploads/page/
        preg_match_all('/uploads\/page\/([a-zA-Z0-9_\-\.\%\+]+)/i', $content, $matches);

        if (empty($matches[1])) {
            return [];
        }

        return collect($matches[1])
            ->map(function ($filename) {
                return urldecode($filename);
            })
            ->unique()
            ->values()
            ->all();
    }

    /**
     * Handle image uploads from the WYSIWYG editor.
     */
    public function upload(Request $request)
    {
        // Accept any file type supported by uploadMedia (mimes include pdf, doc, zip, etc.), with max 1MB limit.
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,gif,ico,svg,webp,pdf,doc,docx,txt,zip,rar,csv,xls,xlsx,ppt,pptx,mp3,avi,mp4,mpeg,3gp,mov,ogg,mkv|max:1024',
        ]);

        $fileName = $this->uploadMedia($request, 'file', 'page');

        if (! $fileName) {
            return response()->json(['error' => 'Upload failed'], 500);
        }

        $url = '/uploads/page/'.$fileName;

        return response()->json(['location' => $url]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        // Delete Attach
        $this->deleteMedia($this->path, $page);
        $this->removeUnusedBuilderImages(is_array($page->builder_sections) ? $page->builder_sections : [], []);

        // Delete WYSIWYG editor files
        $editorFiles = $this->extractEditorFiles($page->content_html);
        foreach ($editorFiles as $file) {
            $path = public_path('uploads/page/'.$file);
            if (File::isFile($path)) {
                File::delete($path);
            }
        }

        // Delete Data
        Page::destroy($page->id);

        Flasher::addSuccess(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
