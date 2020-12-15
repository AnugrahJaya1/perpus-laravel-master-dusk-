<?php
namespace Tests\Browser;
 
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
 
class TransaksiTest extends DuskTestCase { 
 
public function testUnit1(){
 	$this->browse(function (Browser $browser){
 	$browser->loginAs('admin123') 
 	->clickLink('Tambah Transaksi')
 	->press('Cari')
 	->keys('#buku','Android')
 	->keys('#nama','Dipo')
 	->press('Submit')
 	->assertPathIs('/login'); 
 	}); 
} 
 
}