<?php

use Illuminate\Database\Seeder;
use App\Warrantor;

class WarrantorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $warrantors = File::get("database/data/warrantors.json");
        $warrantors = json_decode($warrantors);
        foreach ($warrantors as $warrantor) {
            $warrantorModel = new Warrantor();
            $warrantorModel->name = $warrantor->name;
            $warrantorModel->warrantor_able_type = $warrantor->warrantor_able_type;
            $warrantorModel->warrantor_able_id = $warrantor->warrantor_able_id;
            $warrantorModel->save();
        }
    }
}
