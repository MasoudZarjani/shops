<?php

use Illuminate\Database\Seeder;
use App\Attribute;

class AttributesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attributes = File::get("database/data/attributes.json");
        $attributes = json_decode($attributes);
        foreach ($attributes as $attribute) {
            $attributeModel = new Attribute();
            $attributeModel->input_field_type = $attribute->input_field_type;
            $attributeModel->save();
        }
    }
}
