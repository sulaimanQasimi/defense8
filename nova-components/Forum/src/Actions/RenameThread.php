<?php

namespace Acme\Forum\Actions;

use Acme\Forum\Models\Thread;

class RenameThread extends BaseAction
{
    private Thread $thread;
    private string $title;

    public function __construct(Thread $thread, string $title)
    {
        $this->thread = $thread;
        $this->title = $title;
    }

    protected function transact()
    {
        $this->thread->updateWithoutTouch([
            'title' => $this->title,
        ]);

        return $this->thread;
    }
}
