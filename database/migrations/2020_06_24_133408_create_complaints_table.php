<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('customername')->nullable();
            $table->string('mobile')->nullable();
            $table->longText('details')->nullable();
            $table->longText('image')->nullable();
            $table->bigInteger('complainttype')->nullable();
            $table->bigInteger('complaintsource')->nullable();
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
        Schema::dropIfExists('complaints');
    }
}
