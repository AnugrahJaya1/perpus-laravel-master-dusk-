<?php

namespace Tests\Browser\User;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TambahUser extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testTambahUser()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email','admin123')
                ->type('password','admin123')
                ->press('Login')
                ->visit('/user')
                ->clickLink("Tambah User")
                ->type('name','Test')
                ->type('username','test')
                ->type('email','test@gmail.com')
                ->select('level','user')
                ->type('password','password')
                ->type('password_confirmation','password')
                ->press('Register');

                $this->assertDatabaseHas('users', [
                    'username' => 'test'
                ]);
        });
    }
}
