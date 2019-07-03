<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Relation;

class CreateUserDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_devices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->nullable();
            $table->string('device_id', 64)->nullable();
            $table->string('name')->nullable();
            $table->string('version')->nullable();
            $table->string('push_token')->nullable();
            Relation::Constant($table, 'os', 'device.os.android');
            Relation::Constant($table, 'status', 'device.status.inactive');
            Relation::pointer($table, 'user');
            Relation::Foreign($table, 'user', 'users');
            $table->softDeletes();
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
        Schema::dropIfExists('user_devices');
    }
}
