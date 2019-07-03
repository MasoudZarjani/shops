<?php

use Illuminate\Database\Seeder;
use App\UserDevice;

class UserDevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userDevices = File::get("database/data/userDevices.json");
        $userDevices = json_decode($userDevices);
        foreach ($userDevices as $userDevice) {
            $userDeviceModel = new UserDevice();
            $userDeviceModel->id = $userDevice->id;
            $userDeviceModel->uuid = $userDevice->uuid;
            $userDeviceModel->device_id = $userDevice->device_id;
            $userDeviceModel->name = $userDevice->name;
            $userDeviceModel->version = $userDevice->version;
            $userDeviceModel->push_token = $userDevice->push_token;
            $userDeviceModel->os = $userDevice->os;
            $userDeviceModel->status = $userDevice->status;
            $userDeviceModel->user_id = $userDevice->user_id;
            $userDeviceModel->save();
        }
    }
}
