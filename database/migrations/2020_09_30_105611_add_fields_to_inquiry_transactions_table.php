<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToInquiryTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('inquiry_transactions', function (Blueprint $table) {
            $table->longText('transfer_comment')->nullable();
            $table->longText('resolutionresponse')->nullable();
            $table->smallInteger('responseawait')->default(0);
            $table->timestamp('resolvedate')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inquiry_transactions', function (Blueprint $table) {
            $table->dropColumn('transfer_comment');
            $table->dropColumn('resolutionresponse');
            $table->dropColumn('responseawait');
            $table->dropColumn('resolvedate');
        });
    }
}
