<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatusColumnInOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // If 'status' is an ENUM, add 'completed' to the list of valid values
            $table->enum('status', ['pending', 'completed', 'shipped', 'canceled'])->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // In case of rollback, revert the ENUM values (make sure to remove 'completed' if necessary)
            $table->enum('status', ['pending', 'shipped', 'canceled'])->change();
        });
    }
}
