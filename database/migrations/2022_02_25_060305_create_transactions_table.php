<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // id	date	time	project_id	type	user_id	amount	remark	created_at	updated_at	

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date("date");
            $table->string("project_id");
            $table->string("amount");
            $table->string("type");
            $table->integer("user_id");
            $table->string("remark")->nullable();
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
        Schema::dropIfExists('expense');
    }
}
