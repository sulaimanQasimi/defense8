<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForumTableThreads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_threads', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->foreignIdFor(config('forum.integration.user_model'), 'author_id');
            $table->string('title');

            $table->boolean('pinned')->nullable()->default(0);
            $table->boolean('locked')->nullable()->default(0);

            $table->integer('first_post_id')->unsigned()->nullable();
            $table->integer('reply_count')->default(0);
            $table->integer('last_post_id')->unsigned()->nullable();

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
        Schema::drop('forum_threads');
    }
}
