<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    private const FIELD_LENGTH = 150;

    /**
    Number,Gender,NameSet,Title,GivenName,MiddleInitial,Surname,StreetAddress,City,
    State ,ZipCode,Country,EmailAddress,Username,Password,BrowserUserAgent
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('number')->nullable();
            $table->string('gender', self::FIELD_LENGTH)->nullable();
            $table->string('nameset', self::FIELD_LENGTH)->nullable();
            $table->string('title', self::FIELD_LENGTH)->nullable();
            $table->string('givenname', self::FIELD_LENGTH);
            $table->string('middleinitial', self::FIELD_LENGTH)->nullable();
            $table->string('surname', self::FIELD_LENGTH);
            $table->string('streetaddress', self::FIELD_LENGTH)->nullable();
            $table->string('city', self::FIELD_LENGTH)->nullable();
            $table->string('state', self::FIELD_LENGTH)->nullable();
            $table->string('zipcode', self::FIELD_LENGTH)->nullable();
            $table->string('country', self::FIELD_LENGTH)->nullable();
            $table->string('emailaddress', self::FIELD_LENGTH)->nullable();
            $table->string('username', self::FIELD_LENGTH);
            $table->string('password', self::FIELD_LENGTH)->nullable();
            $table->string('browseruseragent', self::FIELD_LENGTH)->nullable();
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
        Schema::dropIfExists('users');
    }
};