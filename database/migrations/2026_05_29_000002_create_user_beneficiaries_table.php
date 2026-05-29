<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBeneficiariesTable extends Migration
{
    public function up()
    {
        Schema::create('user_beneficiaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('type')->default('bank');
            $table->string('name');
            $table->string('nickname')->nullable();
            $table->string('provider')->nullable();
            $table->string('account_number')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'type']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_beneficiaries');
    }
}
