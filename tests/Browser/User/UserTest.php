<?php
namespace Tests\Browser;
 
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
 
class UserTest extends DuskTestCase { 
 
public function testUnit1(){
 	$this->browse(function (Browser $browser){
 	$browser->loginAs('admin123') 
 	->clickLink('Master Data')
 	->clickLink('Data User')
 	->clickLink('Tambah User')
 	->type('name', 'Test') 
 	->type('username', 'test') 
 	->type('email', 'test@gmail.com') 
 	->attach('cover',base_path('public/images/buku/kodekiddo.png'))
 	->type('gambar', 'dengan') 
 	->select('level','user')
 	->select('level','user')
 	->type('password', 'password') 
 	->press('Register')
 	;});
 	$this->assertDatabaseHas('users',[ 
 	'username' => 'test'
	]);
 	 
} 
 
}