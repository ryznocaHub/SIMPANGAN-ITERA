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
        Schema::create('procurement_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('supplier_id')->nullable()->references('id')->on('suppliers')->onDelete('cascade');
            $table->string('name');
            $table->string('account');
            $table->string('rup_code')->nullable();
            $table->integer('year');
            $table->string('unit');
            $table->string('category');
            $table->foreignId('hps_executor')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->string('executor');
            $table->string('executor_id');
            $table->string('person_responsible');
            $table->string('person_responsible_id');
            $table->string('PPK');
            $table->string('PPK_id');
            $table->string('treasurer');
            $table->string('treasurer_id');
            $table->integer('PPN');
            $table->integer('sub_total');
            $table->integer('total');
            $table->integer('provit')->default(10);
            $table->integer('status');
            $table->string('comment')->nullable();
            $table->timestamp('procurement_start', 6);
            $table->timestamp('rab_submitted', 6)->nullable();
            $table->timestamp('hps_submitted', 6)->nullable();
            $table->timestamp('supplier_submitted', 6)->nullable();
            $table->timestamp('procurement_end', 6)->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('procurement_accounts');
    }
};
