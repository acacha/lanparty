<?php

use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        initialize_gates();

        seed_database();

        initialize_roles();

        create_admin_user();

        first_user_as_manager();
    }
}
