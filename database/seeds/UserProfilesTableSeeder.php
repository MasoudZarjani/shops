<?php

use Illuminate\Database\Seeder;
use App\UserProfile;

class UserProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userProfiles = File::get("database/data/userProfiles.json");
        $userProfiles = json_decode($userProfiles);
        foreach ($userProfiles as $userProfile) {
            $userProfileModel = new UserProfile();
            $userProfileModel->id = $userProfile->id;
            $userProfileModel->full_name = $userProfile->full_name;
            $userProfileModel->first_name = $userProfile->first_name;
            $userProfileModel->last_name = $userProfile->last_name;
            $userProfileModel->user_id = $userProfile->user_id;
            $userProfileModel->save();
        }
    }
}
