<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = File::get("database/data/users.json");
        $users = json_decode($users);
        foreach ($users as $user) {
            $userModel = new User();
            $userModel->id = $user->id;
            $userModel->uuid = $user->uuid;
            $userModel->api_token = $user->api_token;
            $userModel->mobile = $user->mobile;
            $userModel->email = $user->email;
            $userModel->user_name = $user->user_name;
            $userModel->password = $user->password;
            $userModel->reagent_code = $user->reagent_code;
            $userModel->verification_code = $user->verification_code;
            $userModel->role = $user->role;
            $userModel->status = $user->status;
            $userModel->save();
        }
    }
}
