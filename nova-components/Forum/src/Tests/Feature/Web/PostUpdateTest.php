<?php

namespace Acme\Forum\Tests\Feature\Web;

use Illuminate\Foundation\Auth\User;
use Orchestra\Testbench\Factories\UserFactory;
use Acme\Forum\Database\Factories\PostFactory;
use Acme\Forum\Database\Factories\ThreadFactory;
use Acme\Forum\Models\Post;
use Acme\Forum\Support\Web\Forum;
use Acme\Forum\Tests\FeatureTestCase;

class PostUpdateTest extends FeatureTestCase
{
    private const ROUTE = 'post.update';

    private Post $post;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $postFactory = PostFactory::new();
        $threadFactory = ThreadFactory::new();
        $userFactory = UserFactory::new();

        $this->user = $userFactory->createOne();
        $thread = $threadFactory->createOne(['author_id' => $this->user->getKey()]);
        $this->post = $postFactory->createOne(['thread_id' => $thread->getKey(), 'author_id' => $this->user->getKey()]);
    }

    /** @test */
    public function should_fail_validation_with_empty_content()
    {
        $response = $this->actingAs($this->user)
            ->patch(Forum::route(self::ROUTE, $this->post), ['content' => '']);

        $response->assertSessionHasErrors();
    }
}
