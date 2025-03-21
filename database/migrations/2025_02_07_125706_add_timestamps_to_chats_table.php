<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToChatsTable extends Migration
{
    public function up()
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropTimestamps();
        });
    }
}
