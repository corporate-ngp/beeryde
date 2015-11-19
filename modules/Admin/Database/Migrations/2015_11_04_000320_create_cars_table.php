<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('car_brand_id')->unsigned()->index();
            $table->integer('car_model_id')->unsigned()->index();
            $table->string('color', 20)->nullable()->comment = "black, blue, brown, grey, green, purple, red, silver, white, yellow";
            $table->string('comfort', 20)->nullable()->comment = "luxury, comfortable, economy";
            $table->string('seats', 2)->nullable()->comment = "Number of seats allowed 3/4";
            $table->string('registration_number', 50)->nullable()->comment = "Car registration number";
            $table->string('rating', 20)->nullable()->comment = "Car ratings";
            $table->boolean('status')->default(true)->unsigned()->comment = "1 : Active, 0 : Inactive";
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('car_brand_id')->references('id')->on('car_brands')->onDelete('cascade');
            $table->foreign('car_model_id')->references('id')->on('car_models')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cars');
    }
}
