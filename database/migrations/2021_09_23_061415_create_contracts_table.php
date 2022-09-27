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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('no_spk');
            $table->integer('value_spk');
            $table->timestamp('date_spk', 6);
            $table->string('no_sppbj')->nullable();
            $table->timestamp('date_sppbj', 6)->nullable();
            $table->string('purpose_sppbj')->nullable();
            $table->string('no_report')->nullable();
            $table->string('payment')->nullable();
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
        Schema::dropIfExists('contracts');
    }
};
