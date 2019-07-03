<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Relation;

class CreateUserCommunicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_communications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('address')->nullable();
            $table->string('phone', 64)->nullable();
            $table->string('fax', 64)->nullable();
            $table->string('postal_code', 15)->nullable();
            Relation::pointer($table, 'city');
            Relation::constant($table, 'type', 'address.type.home'); 
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
        Schema::dropIfExists('user_communications');
    }
}
