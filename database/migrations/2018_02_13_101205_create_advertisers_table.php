<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('advertisers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('advertiser_id')->nullable();
            $table->string('partner');
            $table->string('company_name');
            $table->string('company_website');
            $table->string('address');
            $table->string('address2');
            $table->string('city');
            $table->string('country');
            $table->string('state');
            $table->string('region');
            $table->string('zip_code');
            $table->string('email');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('title');
            $table->string('phone_number');
            $table->string('company_name_legal');
            $table->string('ein');
            $table->string('skype');
            $table->string('contact_person_finance');
            $table->string('email_finance');
            $table->date('date');
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
        Schema::dropIfExists('advertisers');
    }
}
