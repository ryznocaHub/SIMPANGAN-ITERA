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
        Schema::create('procurement_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('procure_acc_id')->references('id')->on('procurement_accounts')->onDelete('cascade');
            $table->string('name');
            $table->longText('specification')->nullable();
            $table->string('unit');
            $table->integer('quantity');
            $table->integer('price');
            $table->integer('estimate_price')->nullable();
            $table->integer('total');
            $table->integer('estimate_total')->nullable();
            $table->string('allocation');
            $table->string('source');
            $table->string('estimate_source')->nullable();
            $table->string('estimate_file')->nullable();
            $table->string('image')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('procurement_items');
    }
};
