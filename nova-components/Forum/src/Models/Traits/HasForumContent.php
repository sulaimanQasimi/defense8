<?php

namespace Acme\Forum\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Acme\Forum\Models\Post;
use Acme\Forum\Models\Thread;

trait HasForumContent
{
    public function threads(): HasMany
    {
        return $this->hasMany(Thread::class, 'author_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'author_id');
    }
}
