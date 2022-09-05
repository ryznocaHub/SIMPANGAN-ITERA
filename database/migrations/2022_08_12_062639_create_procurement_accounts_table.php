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
            $table->integer('year');
            $table->integer('unit');
            $table->string('category');
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
            $table->integer('status');
            $table->string('rab_file')->nullable();
            $table->string('boq_file')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('procurement_accounts');
    }
};
