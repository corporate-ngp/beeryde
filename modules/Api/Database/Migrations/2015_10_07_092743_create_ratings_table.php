<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {

            $table->string('group_code', 255)->nullable();
            $table->integer('ratings_by')->unsigned();
            $table->integer('ratings_to')->unsigned();
            $table->tinyInteger('ratings', false, true)->default(0);
            $table->foreign('ratings_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('ratings_to')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ratings');
    }
}
