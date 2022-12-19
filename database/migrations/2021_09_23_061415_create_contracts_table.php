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
            $table->string('no_offer')->nullable()->unique();
            $table->bigInteger('offer')->nullable();
            $table->timestamp('date_offer', 6)->nullable();
            $table->string('file_offer')->nullable()->unique();

            $table->string('no_spk')->nullable()->unique();
            $table->string('file_spk')->nullable()->unique();
            $table->string('mak_code')->nullable()->unique();
            $table->string('pic')->nullable();
            $table->string('pic_position')->nullable();
            $table->bigInteger('value_spk')->nullable();
            $table->integer('days')->nullable();
            $table->timestamp('date_start_spk', 6)->nullable();
            $table->timestamp('date_end_spk', 6)->nullable();

            $table->string('no_sppbj')->nullable()->unique();
            $table->string('file_sppbj')->nullable()->unique();
            $table->timestamp('date_sppbj', 6)->nullable();
            $table->string('purpose_sppbj')->nullable();
            $table->string('no_report')->nullable()->unique();
            $table->string('payment')->nullable();

            $table->string('no_sp')->nullable()->unique();
            $table->string('file_sp')->nullable()->unique();
            $table->string('date_sp')->nullable();
            $table->string('paket_sp')->nullable();

            $table->string('no_bastp')->nullable()->unique();
            $table->string('file_bastp')->nullable()->unique();
            $table->timestamp('date_bastp', 6)->nullable();

            $table->string('no_bp')->nullable()->unique();
            $table->string('file_bp')->nullable()->unique();
            $table->timestamp('date_bp', 6)->nullable();

            $table->string('no_bahp')->nullable()->unique();
            $table->string('file_bahp')->nullable()->unique();
            $table->timestamp('date_bahp', 6)->nullable();

            $table->string('no_bap')->nullable()->unique();
            $table->string('file_bap')->nullable()->unique();
            $table->timestamp('date_bap', 6)->nullable();

            $table->string('no_bakn')->nullable()->unique();
            $table->string('file_bakn')->nullable()->unique();
            $table->timestamp('date_bakn', 6)->nullable();

            $table->string('no_baep')->nullable()->unique();
            $table->string('file_baep')->nullable()->unique();
            $table->timestamp('date_baep', 6)->nullable();
            $table->bigInteger('correction')->nullable();
            
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
