<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LogoutTest extends DuskTestCase
{

	public function testUnit1()
	{
		$this->browse(function (Browser $browser) {
			$browser->loginAs('admin123')
				->clickLink('Hello, Gilacoding')
				->clickLink('Sign Out')
				->assertPathIs('/login');
		});
	}
}
