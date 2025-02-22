<?php

use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 */
class DatabaseSeeder extends Seeder {

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call( UserSeeder::class );
        $this->call( ContentManagementSeeder::class );
//        $this->call( CategorySeeder::class );
    }
}
