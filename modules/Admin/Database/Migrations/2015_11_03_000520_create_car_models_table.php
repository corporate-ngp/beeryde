<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarModelsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_models', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('model_name', 255);
            $table->integer('car_brand_id')->unsigned()->index();
            $table->boolean('status')->default(true)->unsigned()->comment = "1 : Active, 0 : Inactive";
            $table->timestamps();
            
            $table->foreign('car_brand_id')->references('id')->on('car_brands')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('car_models');
    }
}
