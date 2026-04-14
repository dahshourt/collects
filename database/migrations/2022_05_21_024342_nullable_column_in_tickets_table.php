<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NullableColumnInTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('account')->nullable()->change();
            $table->foreignId('rejection_reason_id')->nullable()->change();
            $table->foreignId('previous_user_id')->nullable()->change();
            $table->foreignId('previous_status_id')->nullable()->change();
            $table->foreignId('previous_group_id')->nullable()->change();

            $table->foreign('rejection_reason_id')->references('id')->on('rejection_reasons')->onDelete('cascade');
            $table->foreign('previous_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('previous_status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->foreign('previous_group_id')->references('id')->on('groups')->onDelete('cascade');
             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            //
        });
    }
}
