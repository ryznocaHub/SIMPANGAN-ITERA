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
            $table->foreignId('contract_id')->nullable()->references('id')->on('contracts')->onDelete('cascade');
            $table->foreignId('executor_id')->nullable()->references('id')->on('executors')->onDelete('cascade');
            $table->foreignId('timeline_id')->nullable()->references('id')->on('timelines')->onDelete('cascade');
            $table->foreignId('budget_plan_id')->nullable()->references('id')->on('budget_plans')->onDelete('cascade');
            $table->foreignId('estimate_id')->nullable()->references('id')->on('estimates')->onDelete('cascade');
            $table->foreignId('realized_id')->nullable()->references('id')->on('realizeds')->onDelete('cascade');
            $table->string('name');
            $table->longText('description');
            $table->string('account');
            $table->string('rup_code')->nullable();
            $table->integer('year');
            $table->string('unit');
            $table->string('category');
            $table->integer('status');
            $table->string('comment')->nullable();
            
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('procurement_accounts');
    }
};
