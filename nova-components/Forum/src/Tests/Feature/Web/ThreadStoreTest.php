<?php

namespace Acme\Forum\Tests\Feature\Web;

use Illuminate\Foundation\Auth\User;
use Orchestra\Testbench\Factories\UserFactory;
use Acme\Forum\Database\Factories\CategoryFactory;
use Acme\Forum\Models\Category;
use Acme\Forum\Models\Post;
use Acme\Forum\Support\Web\Forum;
use Acme\Forum\Tests\FeatureTestCase;

class ThreadStoreTest extends FeatureTestCase
{
    private const ROUTE = 'thread.store';

    private CategoryFactory $categoryFactory;
    private UserFactory $userFactory;

    private Category $category;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->categoryFactory = CategoryFactory::new();
        $this->userFactory = UserFactory::new();

        $this->category = $this->categoryFactory->createOne();
        $this->user = $this->userFactory->createOne();
    }

    /** @test */
    public function should_302_when_not_logged_in()
    {
        $response = $this->post(Forum::route(self::ROUTE, $this->category), []);
        $response->assertStatus(302);
    }

    /** @test */
    public function should_403_when_category_doesnt_accept_threads()
    {
        $category = $this->categoryFactory->createOne(['accepts_threads' => 0]);
        $response = $this->actingAs($this->user)
            ->post(Forum::route(self::ROUTE, $category), []);

        $response->assertStatus(403);
    }

    /** @test */
    public function should_fail_validation_without_a_title()
    {
        $response = $this->actingAs($this->user)
            ->post(Forum::route(self::ROUTE, $this->category), [
                'title' => '',
                'content' => 'Thread content',
            ]);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function should_fail_validation_without_content()
    {
        $response = $this->actingAs($this->user)
            ->post(Forum::route(self::ROUTE, $this->category), [
                'title' => 'Thread title',
                'content' => '',
            ]);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function should_create_a_post_with_the_thread()
    {
        $this->actingAs($this->user)
            ->post(Forum::route(self::ROUTE, $this->category), [
                'title' => 'Thread title',
                'content' => 'Thread content',
            ]);

        $this->assertEquals(1, Post::count());
    }
}
