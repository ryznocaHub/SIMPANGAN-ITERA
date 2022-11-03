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
            $table->integer('offer');
            $table->timestamp('date_offer', 6)->nullable();
            $table->string('no_offer')->nullable();
            $table->string('no_spk')->nullable();
            $table->string('mak_code')->nullable();
            $table->string('pic')->nullable();
            $table->string('pic_position')->nullable();
            $table->integer('value_spk')->nullable();
            $table->integer('days')->nullable();
            $table->timestamp('date_start_spk', 6)->nullable();
            $table->timestamp('date_end_spk', 6)->nullable();
            $table->string('no_sppbj')->nullable();
            $table->timestamp('date_sppbj', 6)->nullable();
            $table->string('purpose_sppbj')->nullable();
            $table->string('no_report')->nullable();
            $table->string('payment')->nullable();
            $table->string('no_sp')->nullable();
            $table->string('date_sp')->nullable();
            $table->string('paket_sp')->nullable();
            $table->timestamp('date_bastp', 6)->nullable();
            $table->string('no_bastp')->nullable();
            $table->string('no_bahp')->nullable();
            $table->timestamp('date_bahp', 6)->nullable();
            $table->string('no_bap')->nullable();
            $table->timestamp('date_bap', 6)->nullable();
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
