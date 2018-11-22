<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsLogsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('phone');
            $table->string('code')->nullable();
            $table->string('attempt_count')->default(0);
            $table->text('send_message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('sms_logs');
    }
}
