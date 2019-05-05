<?php

use Illuminate\Database\Seeder;
use App\Group;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = File::get("database/data/groups.json");
        $groups = json_decode($groups);
        foreach ($groups as $group) {
            $groupModel = new Group();
            $groupModel->group_id = $group->group_id;
            $groupModel->save();
        }
    }
}
