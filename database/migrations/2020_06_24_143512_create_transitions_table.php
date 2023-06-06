<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transitions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('complaintid');
            $table->bigInteger('fromlevel');
            $table->bigInteger('tolevel');
            $table->bigInteger('fromuser');
            $table->bigInteger('touser');
            $table->bigInteger('departmentid');
            $table->bigInteger('is_transfered')->default(0);
            $table->bigInteger('is_resolved')->default(0);
            $table->bigInteger('resolutionid')->nullable();
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
        Schema::dropIfExists('transitions');
    }
}
