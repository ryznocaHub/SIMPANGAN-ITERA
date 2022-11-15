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
        Schema::create('timelines', function (Blueprint $table) {
            $table->id();
            $table->timestamp('procurement_start', 6);
            $table->timestamp('rab_submitted', 6)->nullable();
            $table->timestamp('siren_approved', 6)->nullable();
            $table->timestamp('rab_reupload', 6)->nullable();
            $table->timestamp('siren_rejected', 6)->nullable();
            $table->timestamp('hps_selected', 6)->nullable();
            $table->timestamp('hps_submitted', 6)->nullable();
            $table->timestamp('hps_rejected', 6)->nullable();
            $table->timestamp('hps_approved', 6)->nullable();
            $table->timestamp('supplier_selected', 6)->nullable();
            $table->timestamp('bakn_created', 6)->nullable();
            $table->timestamp('bahp_created', 6)->nullable();
            $table->timestamp('baep_created', 6)->nullable();
            $table->timestamp('sppbj_created', 6)->nullable();
            $table->timestamp('spk_created', 6)->nullable();
            $table->timestamp('bastp_created', 6)->nullable();
            $table->timestamp('bap_created', 6)->nullable();
            $table->timestamp('spmk_or_spp_created', 6)->nullable();
            $table->timestamp('bp_created', 6)->nullable();
            $table->timestamp('technical_checked', 6)->nullable();
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
        Schema::dropIfExists('timelines');
    }
};
