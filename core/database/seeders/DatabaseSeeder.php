<?php

use Database\Seeders\CurrenciesTableSeeder;
use Database\Seeders\LocalesTableSeeder;
use Database\Seeders\LtmTranslationsTableSeeder;
use Database\Seeders\PermissionsTableSeeder;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
        $this->call(LocalesTableSeeder::class);
        $this->call(LtmTranslationsTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
    }
}
