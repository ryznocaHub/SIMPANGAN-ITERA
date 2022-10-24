<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('npwp')->nullable();
            $table->string('entity')->nullable();
            $table->string('address')->nullable();
            $table->string('province')->nullable();
            $table->string('regency')->nullable();
            $table->string('bank')->nullable();
            $table->string('account')->nullable();
            $table->string('pic')->nullable();
            $table->string('pic_position')->nullable();
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
        Schema::dropIfExists('suppliers');
    }
};
