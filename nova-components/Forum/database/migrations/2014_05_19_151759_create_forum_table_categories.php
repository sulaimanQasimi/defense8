<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForumTableCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->nestedSet();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->boolean('accepts_threads')->default(0);
            $table->integer('newest_thread_id')->unsigned()->nullable();
            $table->integer('latest_active_thread_id')->unsigned()->nullable();
            $table->integer('post_count')->default(0);
            $table->integer('thread_count')->default(0);
            $table->boolean('is_private')->default(0);
            $table->string('color')->nullable();
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
        Schema::drop('forum_categories');
    }
}
