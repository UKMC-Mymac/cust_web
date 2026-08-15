<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Models\Web\Member;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MembersController extends Controller
{
    protected $title;

    protected $route;

    protected $view;

    protected $path;

    protected $access;

    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_member', 1);
        $this->route = 'admin.members';
        $this->view = 'admin.web.members';
        $this->path = 'members';
        $this->access = 'members';

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
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        $search = $request->get('search');
        $query = Member::query();

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('designation', 'like', '%'.$search.'%');
            });
        }

        $data['rows'] = $query->orderBy('serial_no', 'asc')
            ->paginate(25);

        return view($this->view.'.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['access'] = $this->access;
        $data['last_serial_no'] = Member::max('serial_no') ?? 0;

        return view($this->view.'.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'serial_no' => 'required|integer',
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'description' => 'required',
            'status' => 'required|integer|in:0,1',
        ]);

        $member = new Member;
        $member->serial_no = (int) $request->serial_no;
        $member->name = trim((string) $request->name);
        $member->slug = $this->generateUniqueSlug($member->name);
        $member->designation = $request->designation;
        $member->description = $this->normalizeEditorImagePaths($request->description);
        $member->status = (int) $request->status;
        $member->save();

        Flasher::addSuccess(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['access'] = $this->access;
        $data['row'] = $member;

        return view($this->view.'.show-page', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['access'] = $this->access;
        $data['row'] = $member;

        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'serial_no' => 'required|integer',
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'description' => 'required',
            'status' => 'required|integer|in:0,1',
        ]);

        $member->serial_no = (int) $request->serial_no;
        $member->name = trim((string) $request->name);
        $member->slug = $this->generateUniqueSlug($member->name, $member->id);
        $member->designation = $request->designation;
        $member->description = $this->normalizeEditorImagePaths($request->description);
        $member->status = (int) $request->status;
        $member->save();

        Flasher::addSuccess(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        Member::destroy($member->id);

        Flasher::addSuccess(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Search members for editor insertion (AJAX).
     */
    public function search(Request $request)
    {
        $q = (string) $request->get('q', '');

        $rows = Member::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where('name', 'like', '%'.$q.'%')
                    ->orWhere('designation', 'like', '%'.$q.'%');
            })
            ->where('status', 1)
            ->orderBy('name')
            ->limit(20)
            ->get(['id', 'name', 'designation', 'slug', 'description']);

        $results = $rows->map(function ($row) {
            $image = null;

            if (! empty($row->description) && preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $row->description, $m)) {
                $src = $m[1];
                // Normalize TinyMCE relative upload paths like ../uploads/...
                $src = preg_replace('/^(?:\.\.\/)+/', '/', $src);
                // Ensure it starts with a slash if it's a relative path
                if (! preg_match('/^https?:\/\//i', $src) && strpos($src, '/') !== 0) {
                    $src = '/'.ltrim($src, '/');
                }
                $image = $src;
            }

            return [
                'id' => $row->id,
                'name' => $row->name,
                'designation' => $row->designation,
                'slug' => $row->slug,
                'image' => $image,
            ];
        })->values();

        return response()->json($results);
    }

    /**
     * Normalize TinyMCE-generated relative upload paths.
     */
    private function normalizeEditorImagePaths(?string $content): ?string
    {
        if (empty($content)) {
            return $content;
        }

        return preg_replace_callback('/(<img\b[^>]*\bsrc\s*=\s*["\'])([^"\']+)(["\'][^>]*>)/i', function ($matches) {
            $src = $matches[2];
            $path = parse_url($src, PHP_URL_PATH) ?: $src;

            if (preg_match('#^(?:\./|\.\./)*(uploads/.*)$#i', ltrim($path, '/'), $relativeMatch)) {
                return $matches[1].'/'.$relativeMatch[1].$matches[3];
            }

            if (preg_match('#^/+(uploads/.*)$#i', $path, $absoluteMatch)) {
                return $matches[1].'/'.$absoluteMatch[1].$matches[3];
            }

            return $matches[0];
        }, $content);
    }

    /**
     * Generate a unique slug for the member record.
     */
    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name, '-');
        $slug = $baseSlug !== '' ? $baseSlug : Str::random(8);
        $suffix = 1;

        while (Member::query()
            ->when($ignoreId, function ($query) use ($ignoreId) {
                $query->whereKeyNot($ignoreId);
            })
            ->where('slug', $slug)
            ->exists()) {
            $slug = $baseSlug.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }
}
