<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Database\Relations;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->nullable();
            $table->string('mobile')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('api_token')->unique()->nullable();
            $table->string('verification_code', 15)->nullable();

            Relations::Constant($table, 'status', 'user.status.inactive');

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
        Schema::dropIfExists('users');
    }
}
