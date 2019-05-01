<?php

use Illuminate\Database\Seeder;
use App\Helpers\Database\Factory;
use App\Describe;

class DescribesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $describes = File::get("database/data/describes.json");
        $describes = json_decode($describes);
        foreach ($describes as $describe) {
            $describeModel = new Describe();
            $describeModel->title = $describe->title;
            $describeModel->description = $describe->description;
            $describeModel->type = $describe->type;
            $describeModel->describe_able_type = $describe->describe_able_type;
            $describeModel->describe_able_id = $describe->describe_able_id;
            $describeModel->save();
        }
    }
}
