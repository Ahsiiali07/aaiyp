<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed_comments', function (Blueprint $table) {
            $table->id();
            $table->text( 'comment' );
            $table->unsignedBigInteger( 'feed_id' );
            $table->foreign( 'feed_id' )->references( 'id' )->on( 'feeds' )
                ->onDelete( 'cascade' );
            $table->unsignedBigInteger( 'user_id' );
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' )
                ->onDelete( 'cascade' );
            $table->boolean( 'status' )->default( true )->comment( "admin approval flag" );
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
        Schema::dropIfExists('feed_comments');
    }
}
