<?php

use App\Models\User;
use App\Services\Users\IUserType;
use Illuminate\Database\Seeder;

/**
 * Class UserSeeder
 */
class UserSeeder extends Seeder {

    /**
     * @var User $userModel
     */
    private $userModel;

    /**
     * UserSeeder constructor.
     */
    public function __construct() {
        $this->userModel = new User();
    }


    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->userModel->findOrCreate( [
            'email'        => 'admin@admin.com',
            'firstname'    => 'super admin',
            'lastname'    => 'super admin',
            'user_type'    => IUserType::ADMIN,
            'mobile'       => '123456789',
            'image'        => '/public/image/admin',
            'device_token' => 'token',

            'password'     => Hash::make( 'admin' ),
//            'address'       => '1, NY, USA',

        ] );
    }
}
