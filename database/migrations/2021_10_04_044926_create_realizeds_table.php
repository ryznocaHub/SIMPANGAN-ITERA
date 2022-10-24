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
        Schema::create('realizeds', function (Blueprint $table) {
            $table->id();
            $table->integer('sub_total');
            $table->integer('ppn');
            $table->integer('overheat')->default(0);
            $table->float('overheat_percentage', 4, 2);
            $table->integer('total');
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
        Schema::dropIfExists('realizeds');
    }
};
