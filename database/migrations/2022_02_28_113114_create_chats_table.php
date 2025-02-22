<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->string( 'data_time' );
            $table->unsignedBigInteger( 'receiver_id' )->nullable();
            $table->foreign( 'receiver_id' )->references( 'id' )->on( 'users' )
                ->onDelete( 'cascade' );
            $table->unsignedBigInteger( 'sender_id' )->nullable();
            $table->foreign( 'sender_id' )->references( 'id' )->on( 'users' )
                ->onDelete( 'cascade' );
            $table->tinyInteger( 'status' )->default( 0 )->nullable();
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
        Schema::dropIfExists('chats');
    }
}
