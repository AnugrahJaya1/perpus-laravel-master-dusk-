<?php
namespace Tests\Browser;
 
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
 
class BukuTest extends DuskTestCase { 
 
public function testUnit1(){
 	$this->browse(function (Browser $browser){
 	$browser->loginAs('admin123') 
 	->clickLink('Master Data')
 	->clickLink('Data Buku')
 	->clickLink('Tambah Buku')
 	->type('judul', 'Pemgrograman') 
 	->type('isbn', '123456789') 
 	->type('pengarang', 'Muhammad_Dipo') 
 	->type('penerbit', 'PT_Muhammad_Dipo') 
 	->type('tahun_terbit', '2015') 
 	->type('jumlah_buku', '5') 
 	->type('deskripsi', 'Buku_untuk_belajar_Bahasa_Pemrograman_Python') 
 	->select('lokasi','rak1')
 	->select('lokasi','rak1')
 	->attach('cover',base_path('public/images/buku/python.png'))
 	->press('Submit');
 	});
 	$this->assertDatabaseHas('buku',[ 
 	'isbn' => '123456789'
	]);
 	 
} 
 
}