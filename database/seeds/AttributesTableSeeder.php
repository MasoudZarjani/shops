<?php

use Illuminate\Database\Seeder;
use App\Attribute;
use App\Category;

class AttributesTableSeeder extends Seeder
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

        $attributes = Attribute::all();
        $category = Category::ofType(config('constants.category.type.special'))->get();
        foreach ($attributes as $attribute) {
            DB::table('attribute_ables')->insert([
                'attribute_id' => $attribute->id,
                'attribute_able_type' => "App\\Category",
                'attribute_able_id' => $category->random()->id,
            ]);
        }

        $attributes = Attribute::all();
        foreach ($attributes as $attribute) {
            DB::table('attribute_ables')->insert([
                'attribute_id' => $attribute->id,
                'attribute_able_type' => "App\\Category",
                'attribute_able_id' => 2,
            ]);
        }
    }
}
