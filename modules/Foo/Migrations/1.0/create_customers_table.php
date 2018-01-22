<?php
namespace Foo\Migrations;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Schema
{
    public function up()
    {
        Schema::create( 'foo_customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string( 'name' );
            $table->string( 'surname' );
            $table->string( 'phone' );
            $table->string( 'city' );
            $table->string( 'sex' );
            $table->string( 'country' );
            $table->string( 'email' )->unique();
            $table->timestamps();
        });
    }

    /**
     * Running Down method
     */
    public function down()
    {
        Schema::dropIfExists('foo_customers');
    }
}