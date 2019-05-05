<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Database\Relations;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('value');
            $table->bigInteger('user_id');
            $table->bigInteger('describe_id');

            Relations::constant($table, 'type', 'action.type.bookmark');
            Relations::status($table, 'status', 'action.status.active');

            $table->nullableMorphs('message_able');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actions');
    }
}
