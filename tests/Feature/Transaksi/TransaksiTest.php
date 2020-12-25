<?php
namespace Tests\Feature\Transaksi;
 
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
 
use App\Transaksi;
 
use App\Http\Controllers\TransaksiController;
 
use  App\Anggota;
 
class TransaksiTest extends TestCase { 
 
public function testUnit1(){
 	$response = $this->post('/login',[
	'email'=>'admin123@gilacoding.com',
	'password'=>'admin123',
	]);
	$anggota_id = Anggota::where('anggota_id','Test');
	$count = Transaksi::where('anggota_id',$anggota_id)->count();
	$array1 = [
	'judul'=>'Pemrograman_Python',
	'nama'=>'Test',
	];
	$controller = new TransaksiController();
	if($count<=3){
		$controller->storeFunction($array1, $gambar=NULL);
	}
	$newCount = Transaksi::where('anggota_id',$anggota_id)->count();
	$this->assertEquals($count, $newCount-1); 
 	 
} 
 
}