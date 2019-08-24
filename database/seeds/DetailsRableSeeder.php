<?php

use Illuminate\Database\Seeder;
use App\Detail;

class DetailsRableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $details = File::get("database/data/details.json");
        $details = json_decode($details);
        foreach ($details as $detail) {
            $detailModel = new Detail();
            $detailModel->properties = $detail->properties;
            $detailModel->detail_able_type = $detail->detail_able_type;
            $detailModel->detail_able_id = $detail->detail_able_id;
            $detailModel->save();
        }
    }
}
