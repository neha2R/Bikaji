<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionTriggersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_triggers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('action_id');
            $table->bigInteger('role');
            $table->bigInteger('is_email')->default(0);
            $table->bigInteger('is_sms')->default(0);
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
        Schema::dropIfExists('action_triggers');
    }
}
