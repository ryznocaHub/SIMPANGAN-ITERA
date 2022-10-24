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
        Schema::create('executors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siren_approval')  ->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('siren_reject')    ->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('hps')                ->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('ppk')                            ->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('pp')                ->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('contract')          ->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('technical')         ->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->string('treasurer');
            $table->string('treasurer_id');
            $table->string('executor');
            $table->string('executor_id');
            $table->string('person_responsible');
            $table->string('person_responsible_id');
            // $table->foreign('procurement_account_id')->references('id')->on('procurement_account')->onDelete('cascade');
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
        Schema::dropIfExists('executors');
    }
};
