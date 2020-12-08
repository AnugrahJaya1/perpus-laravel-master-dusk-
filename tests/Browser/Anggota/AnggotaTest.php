<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AnggotaTest extends DuskTestCase
{

	public function testUnit1()
	{
		$this->browse(function (Browser $browser) {
			$browser->loginAs('admin123')
				->clickLink('Master Data')
				->clickLink('Data Anggota')
				->clickLink('Tambah Anggota')
				->type('nama', 'Test')
				->type('npm', '0000001')
				->type('tempat_lahir', 'Bandung')
				->keys('#tanggal_lahir', '4271998')
				->select('jenis_kelamin', 'Laki-Laki')
				->select('prodi', 'TI')
				->select('prodi', 'TI')
				->select('user_id', '6')
				->select('user_id', '6')
				->press('Submit');
		});
		$this->assertDatabaseHas('anggota', [
			'npm' => '0000001'
		]);
	}
}
