<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginModalTest extends TestCase
{
    /**
     * Test that contact form validation failure does not set show_login in session.
     */
    public function testContactFormValidationFailureDoesNotSetShowLogin()
    {
        // Post empty data to contact form store
        $response = $this->post(route('contact.store'), []);

        // Assert redirect back (or to contact)
        $response->assertStatus(302);
        
        // Assert there are validation errors
        $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);

        // Assert session does NOT have 'show_login'
        $response->assertSessionMissing('show_login');
    }

    /**
     * Test that failed login sets show_login in session.
     */
    public function testFailedLoginSetsShowLogin()
    {
        // Post empty or incorrect credentials to login
        $response = $this->post(route('login'), [
            'email' => '',
            'password' => '',
        ]);

        // Assert redirect back
        $response->assertStatus(302);

        // Assert validation errors are set
        $response->assertSessionHasErrors(['email', 'password']);

        // Assert session has 'show_login' set to true
        $response->assertSessionHas('show_login', true);
    }
}
