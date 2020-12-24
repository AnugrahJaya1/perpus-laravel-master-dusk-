<?php
namespace Tests\Feature\Auth;
 
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
 
class LoginTest extends TestCase { 
 
public function testUnit1(){
 	$response = $this->post('/login',[
	'email'=>'admin123@gilacoding.com',
	'password'=>'admin123',
	]);
	$response = $this->get('/home');
	$response->assertStatus(200);
	} 
	 
	public function testUnit2(){
 	$response = $this->post('/login',[
	'email'=>'admin123@gilacoding.com',
	'password'=>'admin123',
	]);
	$response = $this->get('/home');
	$response->assertStatus(200);
	} 
	 
	public function testUnit3(){
 	$response = $this->post('/login',[
	'email'=>'admin123@gilacoding.com',
	'password'=>'admin123',
	]);
	$response = $this->get('/home');
	$response->assertStatus(200);
	} 
	 
	public function testUnit4(){
 	$response = $this->post('/login',[
	'email'=>'admin123@gilacoding.com',
	'password'=>'admin123',
	]);
	$response = $this->get('/home');
	$response->assertStatus(200);
	} 
	 
	}