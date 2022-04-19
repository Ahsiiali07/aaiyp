<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportFeedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_feed', function (Blueprint $table) {
            $table->id();
            $table->text( 'reason' )->nullable();
            $table->text( 'detailed_reason' )->nullable();
            $table->unsignedBigInteger( 'user_id' )->nullable();
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' ) ->onDelete( 'cascade' );
            $table->unsignedBigInteger( 'feed_id' );
            $table->foreign( 'feed_id' )->references( 'id' )->on( 'feeds' ) ->onDelete( 'cascade' );
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
        Schema::dropIfExists('report_feed');
    }
}
