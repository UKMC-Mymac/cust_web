<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Models\Setting;

class WebSectionSettingTest extends TestCase
{
    use DatabaseTransactions;

    public function testWebSectionSettingFlow()
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

        // 2. Ensure a Setting record exists
        $setting = Setting::first();
        if (!$setting) {
            $setting = Setting::create([
                'title' => 'CUST',
                'status' => 1,
                'meta_title' => 'CUST',
            ]);
        }

        // 3. Test Web Sections settings page loads
        $response = $this->actingAs($user, 'web')->get(route('admin.web-sections.index'));
        $response->assertStatus(200);
        $response->assertSee('Web Sections Setting');
        $response->assertSee('Hero Banner');

        // 4. Test storing/saving section settings toggles
        $postData = [
            'sections' => [
                'hero' => '1',
                'academics' => '0', // Toggle academics off
                'why-choose-us' => '1',
                'campus-life' => '1',
                'clubs' => '1',
                'testimonials' => '1',
                'student-zone' => '1',
                'news-and-events' => '1',
                'apply' => '1',
                'faq' => '1',
            ]
        ];

        $response = $this->actingAs($user, 'web')->post(route('admin.web-sections.store'), $postData);
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();

        // 5. Verify database setting state
        $setting->refresh();
        $this->assertIsArray($setting->web_sections);
        $this->assertEquals(0, $setting->web_sections['academics']);
        $this->assertEquals(1, $setting->web_sections['hero']);

        // 6. Verify section is hidden on the homepage
        $response = $this->get('/');
        $response->assertStatus(200);
        // Academics section should be hidden (so the academics slider ID "academicSlider2" should not be seen)
        $response->assertDontSee('id="academicSlider2"');
        // Why choose us section is toggled on, so it should still render (we expect to see "why-choose-us" related tags)
        $response->assertSee('why-choose-us');
    }
}
