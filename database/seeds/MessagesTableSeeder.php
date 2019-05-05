<?php

use Illuminate\Database\Seeder;
use App\Message;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $messages = File::get("database/data/messages.json");
        $messages = json_decode($messages);
        foreach ($messages as $message) {
            $messageModel = new Message();
            $messageModel->parent_id = $message->parent_id;
            $messageModel->user_id = $message->user_id;
            $messageModel->message_able_type = $message->message_able_type;
            $messageModel->message_able_id = $message->message_able_id;
            $messageModel->save();
        }
    }
}
