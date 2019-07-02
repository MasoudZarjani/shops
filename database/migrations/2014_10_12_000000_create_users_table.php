<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Database\Relation;

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
            $table->string('api_token')->unique()->nullable();
            $table->string('mobile', 64)->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('user_name')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('reagent_code', 10)->unique()->nullable();
            $table->string('verification_code', 10)->nullable();
            Relation::Constant($table, 'role', 'user.role.user');
            Relation::Constant($table, 'status', 'user.status.inactive');
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
