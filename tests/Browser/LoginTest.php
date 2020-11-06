<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    /**
     * Test fitur login
     *
     * @return void
     */
    // public function testLogin()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->visit('/login')
    //             ->type('email','admin123')
    //             ->type('password','admin123')
    //             ->press('Login')
    //             ->assertPathIs('/home');
    //     });
    // }

    // /**
    //  * Test fitur tambah anggota
    //  */
    // public function testTambahAnggota(){

    //     $this->browse(function (Browser $browser) {
    //         $browser->visit('/anggota')
    //             ->clickLink('Tambah Anggota')
    //             ->type('nama','Muhammad Dipo')
    //             ->type('npm','2016730091')
    //             ->type('tempat_lahir','Bandung')
    //             ->keys('#tgl_lahir', '4271998')
    //             ->select('jk','L')
    //             ->select('prodi','TI')
    //             ->select('user_id','3')
    //             ->press('Submit');
    //     });
    //     $this->assertDatabaseHas('anggota', [
    //         'npm' => '2016730091'
    //     ]);
    // }

    // /**
    //  * Test fitur Log Out
    //  */
    // public function testLogout()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $browser->clickLink('Dipo')
    //         ->clickLink('Sign Out')
    //         ->assertPathIs('/login');
    //     });
    // }
    public function testLogin()
    {
        $user = factory(User::class)->create();
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
            ->visit('/home');
        });
    }
}
