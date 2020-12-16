<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->post('/login',[
            'email' => 'admin123@gilacoding.com',
            'password' => 'admin123',
        ]);

        $response = $this->get('/home');

        $response->assertStatus(200);
    }
}
