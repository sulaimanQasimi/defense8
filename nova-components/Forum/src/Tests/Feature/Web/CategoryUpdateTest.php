<?php

namespace Acme\Forum\Tests\Feature\Web;

use Illuminate\Foundation\Auth\User;
use Orchestra\Testbench\Factories\UserFactory;
use Acme\Forum\Database\Factories\CategoryFactory;
use Acme\Forum\Models\Category;
use Acme\Forum\Support\Web\Forum;
use Acme\Forum\Tests\FeatureTestCase;

class CategoryUpdateTest extends FeatureTestCase
{
    private const ROUTE = 'category.update';

    private Category $category;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $categoryFactory = CategoryFactory::new();
        $userFactory = UserFactory::new();

        $this->category = $categoryFactory->createOne();
        $this->user = $userFactory->createOne();
    }

    /** @test */
    public function should_fail_validation_without_a_title()
    {
        $response = $this->actingAs($this->user)
            ->patch(Forum::route(self::ROUTE, $this->category), ['title' => '']);

        $response->assertSessionHasErrors();
    }
}
