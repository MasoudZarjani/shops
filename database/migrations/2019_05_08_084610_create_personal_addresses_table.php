<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Database\Relations;

class CreatePersonalAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('address')->nullable();
            $table->string('postal_code', 15)->nullable();

            Relations::pointer($table, 'city');

            Relations::constant($table, 'type', 'address.type.home');            

            $table->nullableMorphs('address_able');

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
        Schema::dropIfExists('personal_addresses');
    }
}
