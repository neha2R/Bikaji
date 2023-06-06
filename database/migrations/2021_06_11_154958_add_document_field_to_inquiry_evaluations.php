<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDocumentFieldToInquiryEvaluations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inquiry_evaluations', function (Blueprint $table) {
            $table->string('document')->nullable()
            ->comment = 'Only visible to admin or CEO';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inquiry_evaluations', function (Blueprint $table) {
            //
        });
    }
}
