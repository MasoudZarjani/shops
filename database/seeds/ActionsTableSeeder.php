<?php

use Illuminate\Database\Seeder;
use App\Action;

class ActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actions = File::get("database/data/actions.json");
        $actions = json_decode($actions);
        foreach ($actions as $action) {
            $actionModel = new Action();
            $actionModel->value = $action->value;
            $actionModel->user_id = $action->user_id;
            $actionModel->describe_id = $action->describe_id;
            $actionModel->action_able_type = $action->action_able_type;
            $actionModel->action_able_id = $action->action_able_id;
            $actionModel->save();
        }
    }
}
