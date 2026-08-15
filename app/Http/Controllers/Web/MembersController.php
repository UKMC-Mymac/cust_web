<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Web\Member;
use App\Services\BreadcrumbService;


class MembersController extends Controller
{
    /**
     * Display public listing of members.
     */
    public function index()
    {
        $data['members'] = Member::query()
            ->where('status', '=', 1)
            ->orderBy('id', 'asc')
            ->paginate(24);

        $breadcrumbData = BreadcrumbService::generate('members', ['title' => 'Members']);
        $data = array_merge($data, $breadcrumbData);

        return view('web.members', $data);
    }

    /**
     * Display a single member details page by slug.
     */
    public function show($slug)
    {
        $data['member'] = Member::query()
            ->where('slug', '=', $slug)
            ->where('status', '=', 1)
            ->firstOrFail();

        $breadcrumbData = BreadcrumbService::generate('members.show', [
            'title' => $data['member']->name,
            'current_label' => $data['member']->name,
        ]);
        $data = array_merge($data, $breadcrumbData);

        return view('web.member-single', $data);
    }
}