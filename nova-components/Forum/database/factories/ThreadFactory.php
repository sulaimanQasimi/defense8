<?php

namespace Acme\Forum\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Acme\Forum\Models\Thread;

class ThreadFactory extends Factory
{
    protected $model = Thread::class;

    public function definition()
    {
        return [
            'title' => $this->faker->name,
            'category_id' => CategoryFactory::new(),
            'locked' => 0,
            'pinned' => 0,
            'reply_count' => 0,
            'deleted_at' => null,
        ];
    }
}
