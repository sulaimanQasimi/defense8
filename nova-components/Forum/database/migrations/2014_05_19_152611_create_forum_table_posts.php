<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateForumTablePosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('thread_id')->unsigned();
            $table->foreignIdFor(User::class, 'author_id');
            $table->text('content');
            $table->integer('post_id')->unsigned()->nullable();
            $table->integer('sequence')->unsigned()->default(0);

            $table->timestamps();
            $table->softDeletes();
        });


        Schema::table('forum_posts', function (Blueprint $table) {
            $table->index('thread_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('forum_posts');

        Schema::table('forum_posts', function (Blueprint $table) {
            $table->dropIndex('forum_posts_thread_id_index');
        });
    }
}
