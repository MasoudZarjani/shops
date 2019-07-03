<?php

use Illuminate\Database\Seeder;
use App\UserCommunication;

class UserCommunicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userDevices = File::get("database/data/userCommunications.json");
        $userDevices = json_decode($userDevices);
        foreach ($userDevices as $userDevice) {
            $userDeviceModel = new UserCommunication();
            $userDeviceModel->address = $userDevice->address;
            $userDeviceModel->phone = $userDevice->phone;
            $userDeviceModel->fax = $userDevice->fax;
            $userDeviceModel->postal_code = $userDevice->postal_code;
            $userDeviceModel->city_id = $userDevice->city_id;
            $userDeviceModel->type = $userDevice->type;
            $userDeviceModel->user_id = $userDevice->user_id;
            $userDeviceModel->save();
        }
    }
}
