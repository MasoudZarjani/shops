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
            $table->tinyInteger('value')->default(0);
            $table->bigInteger('user_id')->default(0);
            $table->bigInteger('describe_id')->default(0);
            Relation::constant($table, 'type', 'action.type.question');
            Relation::status($table, 'status', 'action.status.active');
            $table->nullableMorphs('action_able');
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
