<?php

namespace App\Http\Controllers\Admin\Web;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Web\Navbar;
use App\Models\Web\Page;
use Flasher\Laravel\Facade\Flasher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class NavbarController extends Controller
{
    protected $title;

    protected $route;

    protected $view;

    protected $path;

    protected $access;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->title = 'Navbar';
        $this->route = 'admin.navbar';
        $this->view = 'admin.web.navbar';
        $this->path = 'navbar';
        $this->access = 'navbar';

        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit', 'update', 'reorder']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        $data['rows'] = Navbar::query()
            ->where('language_id', Language::version()->id)
            ->whereNull('parent_id')
            ->with(['childrenRecursive', 'page'])
            ->orderBy('sort_order', 'asc')
            ->get();

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

        $data['parents'] = Navbar::query()
            ->where('language_id', Language::version()->id)
            ->orderBy('sort_order', 'asc')
            ->get();

        $data['pages'] = Page::query()
            ->where('language_id', Language::version()->id)
            ->where('status', 1)
            ->orderBy('title', 'asc')
            ->get();

        return view($this->view.'.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $internalRoutes = array_keys(config('navbars.internal_links', []));

        $request->validate([
            'label' => 'required',
            'parent_id' => 'nullable|exists:navbars,id',
            'page_id' => 'nullable|exists:pages,id|required_without_all:url,route_name',
            'url' => 'nullable|string|required_without_all:page_id,route_name',
            'route_name' => ['nullable', Rule::in($internalRoutes)],
            'target' => 'nullable|in:_self,_blank',
        ]);

        $pageId = $request->page_id ?: null;
        $routeName = $pageId ? null : ($request->route_name ?: null);
        $url = ($pageId || $routeName) ? null : $request->url;

        DB::transaction(function () use ($request, $pageId, $routeName, $url) {
            $parentId = $request->parent_id ?: null;
            $navbar = new Navbar;
            $navbar->language_id = Language::version()->id;
            $navbar->label = $request->label;
            $navbar->parent_id = $parentId;
            $navbar->page_id = $pageId;
            $navbar->route_name = $routeName;
            $navbar->url = $url;
            $navbar->target = $request->input('target', '_self');
            $navbar->sort_order = $this->nextSortOrder($parentId, $navbar->language_id);
            $navbar->status = (int) $request->input('status', 0);
            $navbar->save();
        });

        Flasher::addSuccess('Navbar item created successfully', 'Success');

        return redirect()->route($this->route.'.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route($this->route.'.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['access'] = $this->access;

        $data['row'] = Navbar::query()->findOrFail($id);

        $data['parents'] = Navbar::query()
            ->where('language_id', Language::version()->id)
            ->where('id', '!=', $id)
            ->orderBy('sort_order', 'asc')
            ->get();

        $data['pages'] = Page::query()
            ->where('language_id', Language::version()->id)
            ->where('status', 1)
            ->orderBy('title', 'asc')
            ->get();

        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $internalRoutes = array_keys(config('navbars.internal_links', []));

        $request->validate([
            'label' => 'required',
            'parent_id' => 'nullable|exists:navbars,id',
            'page_id' => 'nullable|exists:pages,id|required_without_all:url,route_name',
            'url' => 'nullable|string|required_without_all:page_id,route_name',
            'route_name' => ['nullable', Rule::in($internalRoutes)],
            'target' => 'nullable|in:_self,_blank',
        ]);

        if ((int) $request->input('parent_id') === (int) $id) {
            return redirect()->back()
                ->withErrors(['parent_id' => 'Parent item cannot be the same item.'])
                ->withInput();
        }

        $pageId = $request->page_id ?: null;
        $routeName = $pageId ? null : ($request->route_name ?: null);
        $url = ($pageId || $routeName) ? null : $request->url;

        DB::transaction(function () use ($request, $id, $pageId, $routeName, $url) {
            $navbar = Navbar::query()->findOrFail($id);
            $oldParentId = $navbar->parent_id;
            $newParentId = $request->parent_id ?: null;

            $navbar->label = $request->label;
            $navbar->parent_id = $newParentId;
            $navbar->page_id = $pageId;
            $navbar->route_name = $routeName;
            $navbar->url = $url;
            $navbar->target = $request->input('target', '_self');
            $navbar->status = (int) $request->input('status', 0);

            if ((int) $oldParentId !== (int) $newParentId) {
                $navbar->sort_order = $this->nextSortOrder($newParentId, $navbar->language_id);
            }

            $navbar->save();

            if ((int) $oldParentId !== (int) $newParentId) {
                $this->normalizeSiblings($oldParentId, $navbar->language_id);
            }
        });

        Flasher::addSuccess('Navbar item updated successfully', 'Success');

        return redirect()->route($this->route.'.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::transaction(function () use ($id) {
            $navbar = Navbar::query()->findOrFail($id);
            $parentId = $navbar->parent_id;
            $languageId = $navbar->language_id;
            $childrenCount = $navbar->children()->count();

            $navbar->delete();

            $this->normalizeSiblings($parentId, $languageId);
            if ($childrenCount > 0) {
                $this->normalizeSiblings(null, $languageId);
            }
        });

        Flasher::addSuccess('Navbar item deleted successfully', 'Success');

        return redirect()->route($this->route.'.index');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'tree' => 'required|array',
        ]);

        DB::transaction(function () use ($request) {
            $this->applyOrder($request->input('tree', []), null);
        });

        return response()->json(['status' => 'ok']);
    }

    private function applyOrder(array $items, ?int $parentId): void
    {
        foreach ($items as $index => $item) {
            if (empty($item['id'])) {
                continue;
            }

            Navbar::query()->where('id', $item['id'])->update([
                'parent_id' => $parentId,
                'sort_order' => $index,
            ]);

            if (! empty($item['children']) && is_array($item['children'])) {
                $this->applyOrder($item['children'], $item['id']);
            }
        }
    }

    private function nextSortOrder(?int $parentId, int $languageId): int
    {
        $maxOrder = Navbar::query()
            ->where('language_id', $languageId)
            ->where('parent_id', $parentId)
            ->max('sort_order');

        return is_null($maxOrder) ? 0 : $maxOrder + 1;
    }

    private function normalizeSiblings(?int $parentId, int $languageId): void
    {
        $siblings = Navbar::query()
            ->where('language_id', $languageId)
            ->where('parent_id', $parentId)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->get(['id']);

        foreach ($siblings as $index => $sibling) {
            Navbar::query()->where('id', $sibling->id)->update(['sort_order' => $index]);
        }
    }
}
