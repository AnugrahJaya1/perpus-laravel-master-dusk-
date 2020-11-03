<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email','user123')
                ->type('password','user123')
                ->press('Login')
                ->assertSee('Hello, Gilacoding');//atau bisa pakai waitForText
        });
    }

    public function testLogout()
    {
        $this->browse(function (Browser $browser) {
            // $browser->visit('/login')
            //     ->type('email','user123')
            //     ->type('password','user123')
            //     ->press('Login')
                $browser->click('a[href="#"]')
                ->click('a[href="http://localhost:8000/logout"]')
                ->assertSee('PERPUSKU');//atau bisa pakai waitForText
        });
    }
}
