<?php

use App\Models\User;
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
            $table->foreignIdFor(User::class, 'author_id');
            $table->string('title');

            $table->boolean('pinned')->nullable()->default(0);
            $table->boolean('locked')->nullable()->default(0);

            $table->integer('first_post_id')->unsigned()->nullable();
            $table->integer('reply_count')->default(0);
            $table->integer('last_post_id')->unsigned()->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
        Schema::table('forum_threads', function (Blueprint $table) {
            $table->index('category_id');
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

        Schema::table('forum_threads', function (Blueprint $table) {
            $table->dropIndex('forum_threads_category_id_index');
        });
    }
}
