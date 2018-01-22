<?php
namespace Foo\Migrations;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DoSomethingElse extends Schema
{
    public function up()
    {
        Schema::create( 'foo_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string( 'name' );
            $table->float( 'sale_price' );
            $table->float( 'purchase_price' );
            $table->string( 'sku' )->unique();
            $table->string( 'barcode' )->unique();
            $table->timestamps();
        });
    }

    /**
     * Running Down method
     */
    public function down()
    {
        Schema::dropIfExists('foo_items');
    }
}