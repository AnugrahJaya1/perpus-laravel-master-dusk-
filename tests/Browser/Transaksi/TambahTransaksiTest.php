<?php

namespace Tests\Browser\Transaksi;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TambahTransaksiTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            
            
            $browser->visit('/login')
                ->type('email','admin123')
                ->type('password','admin123')
                ->press('Login')
                ->visit('/transaksi')
                ->clickLink("Tambah Transaksi")
                ->press("Cari Buku")
                ->waitForText("Cari Buku")
                ->click("tr[data-buku_id='2']")
                ->press("Cari Anggota")
                ->waitForText("Cari Anggota")
                ->click("tr[data-anggota_id='2']")
                ->type('ket',$browser->value("#kode_transaksi"))
                ->press("Submit")
                ->waitForText("Berhasil");
                // ->assertSee("Berhasil");// lihat dari UI
                $kode_transaksi = strval($browser->value("#kode_transaksi"));
                $this->assertDatabaseHas('transaksi', [
                    'kode_transaksi' => $kode_transaksi
                ]);
        });
    }
}
