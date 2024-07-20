<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetDefaultValueForAccountIdInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Modify the 'account_id' column to have a default value of 1
            $table->unsignedBigInteger('account_id')->default(1);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Rollback changes: remove the default value if necessary
            $table->unsignedBigInteger('account_id')->nullable();
        });
    }
}
