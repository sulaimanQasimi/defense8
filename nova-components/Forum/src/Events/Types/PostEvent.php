<?php

namespace Acme\Forum\Events\Types;

use Acme\Forum\Models\Post;

class PostEvent extends BaseEvent
{
    /** @var mixed */
    public $user;

    public Post $post;

    public function __construct($user, Post $post)
    {
        $this->user = $user;
        $this->post = $post;
    }
}
