<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wagers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('total_wager_value');
            $table->integer('odds');
            $table->integer('selling_percentage');
            $table->double('selling_price');
            $table->double('current_selling_price');
            $table->integer('percentage_sold')->nullable();
            $table->double('amount_sold')->nullable();
            $table->timestamp('placed_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wagers');
    }
}
