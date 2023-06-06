<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('customername')->nullable();
            $table->longText('details')->nullable();
            $table->string('contact')->nullable();
            $table->string('email')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode')->nullable();
            $table->string('city')->nullable();
            $table->bigInteger('inquirysource')->nullable();
            $table->bigInteger('createdby')->nullable();
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
        Schema::dropIfExists('inquiries');
    }
}
