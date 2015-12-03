<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name', 120)->nullable();
            $table->string('email', 100)->nullable()->unique()->index();
            $table->string('password', 100)->nullable();
            $table->boolean('status')->default(true)->unsigned()->index()->comment = "1 : Active, 0 : Inactive";
            $table->string('contact', 20)->nullable()->comment = "Contact number either phone or mobile";
            $table->boolean('gender')->nullable()->comment = "1 : Male, 0 : Female";
            $table->date('dob')->nullable()->comment = "Date Of Birth";
            $table->string('avatar', 255)->nullable()->comment = "User profile picture";
            $table->string('ratings', 20)->nullable()->comment = "User ratings";
            $table->boolean('sms_notification')->default(true)->unsigned()->comment = "1 : Active, 0 : Inactive";
            $table->boolean('push_notification')->default(true)->unsigned()->comment = "1 : Active, 0 : Inactive";
            $table->string('occupation', 100)->nullable();
            $table->string('profession_details', 100)->nullable();
            $table->string('emergency_contact_1', 20)->nullable()->comment = "Contact number either phone or mobile";
            $table->string('emergency_contact_2', 20)->nullable()->comment = "Contact number either phone or mobile";
            $table->string('id_proof_type', 100)->nullable()->comment = "Type of identity proof";
            $table->string('id_proof', 255)->nullable()->comment = "User identity proof attachment";
            $table->boolean('music')->nullable()->unsigned()->comment = "1 : Active, 0 : Inactive";
            $table->boolean('smoking')->nullable()->unsigned()->comment = "1 : Active, 0 : Inactive";
            $table->string('corporate_email', 100)->nullable();
            $table->string('mobile_verification', 10)->nullable();
            $table->string('email_verification', 10)->nullable();
            $table->string('facebook_id', 50)->nullable();
            $table->string('googleplus_id', 50)->nullable();               
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
