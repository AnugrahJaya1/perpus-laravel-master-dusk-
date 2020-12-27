<?php
namespace Tests\Browser;
 
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
 
class TransaksiTest extends DuskTestCase { 
 
public function testUnit1(){
 	$this->browse(function (Browser $browser){
 	$browser->visit('/login') 
 	->type('email', 'admin123@gilacoding.com') 
 	->type('password', 'admin123') 
 	->press('Login')
 	->clickLink('Transaksi Buku')
 	->clickLink('Tambah Transaksi')
 	->type('tgl_pinjam', '01012021') 
 	->type('tgl_kembali', '01052021') 
 	->press('Cari Buku')
 	->waitForText('Cari Buku')
 	