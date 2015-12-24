<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRidesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rides', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('user_id')->nullable()->unsigned()->index();
            $table->string('ride_from', 255)->index();
            $table->string('from_lat_long', 100)->nullable()->comment = "Comma separated from latitude and longitude";
            $table->string('ride_to', 255)->index();
            $table->string('to_lat_long', 100)->nullable()->comment = "Comma separated to latitude and longitude";
            $table->string('price', 10);
            $table->timestamp('ride_date');
            $table->integer('car_id')->nullable()->unsigned()->index();
            $table->boolean('status')->default(true)->unsigned()->index()->comment = "1 : Active, 0 : Inactive";
            $table->boolean('return_ride')->default(false)->unsigned()->comment = "1 : Return, 0 : Non return";
            $table->timestamp('ride_return_date');
            $table->boolean('multiple_times_travels')->default(false)->unsigned()->comment = "1 : Yes, 0 : No";
            $table->string('multiple_times_travels_dates', 255)->nullable()->comment = "comma separated dates";
            $table->string('seats', 2)->nullable()->comment = "Number of seats allowed 3/4";
            $table->string('luggage_size', 50)->nullable()->comment = "No luggage,light,medium,heavy";
            $table->string('waiting_time', 50)->nullable()->comment = "No waiting,min 15 min,max 30min,max 1hr";
            $table->string('detour_time', 50)->nullable()->comment = "No detour,min 15 min,max 30min,max 1hr";
            $table->string('ride_preference', 50)->nullable()->comment = "male/female allow-female,male,both";
            $table->string('ride_purpose', 255)->nullable()->comment = "Description of purpose of ride";
            $table->boolean('auto_approval_booking')->default(true)->unsigned()->comment = "1 : Yes, 0 : No";
            $table->string('boarding_point1', 255)->nullable();
            $table->string('boarding_point1_lat_long', 100)->nullable()->comment = "Comma separated from latitude and longitude";
            $table->string('boarding_point1_fair', 10)->nullable();
            $table->string('boarding_point2', 255)->nullable();
            $table->string('boarding_point2_lat_long', 100)->nullable()->comment = "Comma separated from latitude and longitude";
            $table->string('boarding_point2_fair', 10)->nullable();
            $table->string('boarding_point3', 255)->nullable();
            $table->string('boarding_point3_lat_long', 100)->nullable()->comment = "Comma separated from latitude and longitude";
            $table->string('boarding_point3_fair', 10)->nullable();
            $table->string('boarding_point4', 255)->nullable();
            $table->string('boarding_point4_lat_long', 100)->nullable()->comment = "Comma separated from latitude and longitude";
            $table->string('boarding_point4_fair', 10)->nullable();
            $table->string('boarding_point5', 255)->nullable();
            $table->string('boarding_point5_lat_long', 100)->nullable()->comment = "Comma separated from latitude and longitude";
            $table->string('boarding_point5_fair', 10)->nullable();
            $table->string('boarding_point6', 255)->nullable();
            $table->string('boarding_point6_lat_long', 100)->nullable()->comment = "Comma separated from latitude and longitude";
            $table->string('boarding_point6_fair', 10)->nullable();
            $table->string('boarding_point7', 255)->nullable();
            $table->string('boarding_point7_lat_long', 100)->nullable()->comment = "Comma separated from latitude and longitude";
            $table->string('boarding_point7_fair', 10)->nullable();
            $table->string('boarding_point8', 255)->nullable();
            $table->string('boarding_point8_lat_long', 100)->nullable()->comment = "Comma separated from latitude and longitude";
            $table->string('boarding_point8_fair', 10)->nullable();
            $table->string('destinationfair', 10)->nullable();
            $table->boolean('seat1')->default(0)->unsigned()->comment = "0 - unavailable, 1 - available, 2 - block";
            $table->boolean('seat2')->default(1)->unsigned()->comment = "0 - unavailable, 1 - available, 2 - block";
            $table->boolean('seat3')->default(1)->unsigned()->comment = "0 - unavailable, 1 - available, 2 - block";
            $table->boolean('seat4')->default(1)->unsigned()->comment = "0 - unavailable, 1 - available, 2 - block";
            $table->boolean('seat5')->default(1)->unsigned()->comment = "0 - unavailable, 1 - available, 2 - block";
            $table->boolean('seat6')->default(1)->unsigned()->comment = "0 - unavailable, 1 - available, 2 - block";
            $table->boolean('seat7')->default(1)->unsigned()->comment = "0 - unavailable, 1 - available, 2 - block";
            $table->boolean('seat8')->default(1)->unsigned()->comment = "0 - unavailable, 1 - available, 2 - block";
            $table->boolean('pets_allow')->nullable()->unsigned()->comment = "1 : Yes, 0 : No";
            $table->boolean('smoking_allow')->nullable()->unsigned()->comment = "1 : Yes, 0 : No";
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rides');
    }
}
