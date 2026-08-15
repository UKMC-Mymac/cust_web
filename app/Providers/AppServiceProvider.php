<?php

namespace App\Providers;

use App\Models\Language;
use App\Models\ScheduleSetting;
use App\Models\Setting;
use App\Models\Web\ContentSection;
use App\Models\Web\FooterSection;
use App\Models\Web\Navbar;
use App\Models\Web\Page;
use App\Models\Web\SocialSetting;
use App\Models\Web\TopbarSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        // Share view for Common Data
        $user_languages = Language::query()->where('status', 1)->get();
        $setting = Setting::query()->where('status', 1)->first();
        $topbarSetting = TopbarSetting::query()->where('status', 1)->first();
        $socialSetting = SocialSetting::query()->where('status', 1)->first();
        $schedule_setting = ScheduleSetting::query()->where('slug', 'fees-schedule')->first();
        $footer_pages = Page::query()->where('language_id', Language::version()->id)
            ->where('status', 1)
            ->orderBy('id', 'asc')
            ->first();

        $navbarItems = collect();
        if (Schema::hasTable('navbars')) {
            $navbarItems = Navbar::query()
                ->where('language_id', Language::version()->id)
                ->whereNull('parent_id')
                ->where('status', 1)
                ->with(['activeChildrenRecursive', 'page'])
                ->orderBy('sort_order')
                ->get();
        }

        // Fetch footer sections if table exists
        $footerSections = collect();
        if (Schema::hasTable('footer_sections')) {
            $footerSections = FooterSection::query()->where('language_id', Language::version()->id)
                ->where('status', 1)
                ->with('links.page')
                ->orderBy('sort_order', 'asc')
                ->get();
        }

        // Fetch student zones if table exists
        $studentZones = collect();
        if (Schema::hasTable('student_zones')) {
            $studentZones = \App\Models\Web\StudentZone::query()
                ->where('status', 1)
                ->orderBy('order', 'asc')
                ->with('page')
                ->get();
        }

        // Fetch clubs if table exists
        $clubs = collect();
        if (Schema::hasTable('clubs')) {
            $clubs = \App\Models\Web\Club::query()
                ->orderBy('id', 'asc')
                ->with('page')
                ->get();
        }

        $contentSections = collect();
        if (Schema::hasTable('content_sections')) {
            $contentSections = ContentSection::query()->where('language_id', Language::version()->id)
                ->where('status', 1)
                ->get()
                ->keyBy('key');
        }

        // Fetch custom URLs if table exists
        $custom_urls = collect();
        if (Schema::hasTable('custom_urls')) {
            $custom_urls = \App\Models\CustomUrl::where('status', 1)->get()->keyBy('key');
        }

        // Set Time Zone
        Config::set('app.timezone', $setting->time_zone);

        View::share(['setting' => $setting, 'user_languages' => $user_languages, 'schedule_setting' => $schedule_setting, 'topbarSetting' => $topbarSetting, 'socialSetting' => $socialSetting, 'footer_pages' => $footer_pages, 'footerSections' => $footerSections, 'studentZones' => $studentZones, 'clubs' => $clubs, 'contentSections' => $contentSections, 'navbarItems' => $navbarItems, 'custom_urls' => $custom_urls]);
    }
}
