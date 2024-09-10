<?php

namespace Acme\Forum\Tests\Feature\Web;

use Illuminate\Foundation\Auth\User;
use Orchestra\Testbench\Factories\UserFactory;
use Acme\Forum\Support\Web\Forum;
use Acme\Forum\Tests\FeatureTestCase;

class CategoryStoreTest extends FeatureTestCase
{
    private const ROUTE = 'category.store';

    private UserFactory $userFactory;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userFactory = UserFactory::new();
        $this->user = $this->userFactory->createOne();
    }

    /** @test */
    public function should_fail_validation_without_a_title()
    {
        $response = $this->actingAs($this->user)
            ->post(Forum::route(self::ROUTE), ['title' => '']);

        $response->assertSessionHasErrors();
    }
}
