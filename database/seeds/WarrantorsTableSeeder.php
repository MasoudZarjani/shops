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
            $warrantorModel->status = $warrantor->status;
            $warrantorModel->save();
        }
    }
}
