<?php

namespace Tests\Browser\Auth;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LogoutTest extends DuskTestCase
{
    public function testLogout()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email','admin123')
                ->type('password','admin123')
                ->press('Login')
                ->clickLink("Hello, Gilacoding")
                ->clickLink("Sign Out")
                ->assertPathIs('/login');//atau bisa pakai waitForText
        });
    }
}
