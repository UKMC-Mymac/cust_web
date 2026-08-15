<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Models\NoticeCategory;
use App\Models\Language;
use App\Services\BreadcrumbService;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index(Request $request)
    {
        $data['title'] = 'Notices';
        
        // Get all categories for dropdown
        $data['categories'] = NoticeCategory::where('status', '1')
                                ->orderBy('title', 'asc')
                                ->get();

        // Get selected category slug from request
        $categorySlug = $request->get('category', null);
        
        // Build query
        $query = Notice::where('status', '1')
                        ->orderBy('date', 'desc');

        // Filter by category slug if selected
        if(!empty($categorySlug)){
            $category = NoticeCategory::where('slug', $categorySlug)->first();
            if($category){
                $query->whereHas('categories', function($q) use ($category) {
                    $q->where('notice_categories.id', $category->id);
                });
                $data['selected_category'] = $categorySlug;
            } else {
                $data['selected_category'] = null;
            }
        } else {
            $data['selected_category'] = null;
        }

        // Paginate results (20 per page)
        $data['notices'] = $query->paginate(20);

        // Breadcrumbs
        $breadcrumbs = BreadcrumbService::generate('notice', ['title' => $data['title'], 'current_label' => $data['title']]);
        $data = array_merge($data, $breadcrumbs);

        return view('web.notice', $data);
    }

    public function show(Notice $notice)
    {
        // Check if notice is published
        if($notice->status != '1'){
            abort(404);
        }

        $data['title'] = $notice->title;
        $data['notice'] = $notice;

        // Get related notices from same category
        $categoryIds = $notice->categories->pluck('id')->toArray();
        $data['related_notices'] = Notice::where('status', '1')
                                    ->whereHas('categories', function($q) use ($categoryIds) {
                                        $q->whereIn('notice_categories.id', $categoryIds);
                                    })
                                    ->where('id', '!=', $notice->id)
                                    ->orderBy('date', 'desc')
                                    ->limit(5)
                                    ->get();

        // Breadcrumbs
        $breadcrumbs = BreadcrumbService::generate('notice.show', ['title' => $notice->title, 'current_label' => $notice->title]);
        $data = array_merge($data, $breadcrumbs);

        return view('web.notice.show', $data);
    }

}