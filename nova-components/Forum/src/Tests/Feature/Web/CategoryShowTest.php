<?php

namespace Acme\Forum\Tests\Feature\Web;

use Acme\Forum\Database\Factories\CategoryFactory;
use Acme\Forum\Models\Category;
use Acme\Forum\Support\Web\Forum;
use Acme\Forum\Tests\FeatureTestCase;

class CategoryShowTest extends FeatureTestCase
{
    private const ROUTE = 'category.show';

    private Category $topLevelCategory;
    private Category $secondLevelCategory;
    private Category $thirdLevelCategory;

    protected function setUp(): void
    {
        parent::setUp();

        $categoryFactory = CategoryFactory::new();
        $this->topLevelCategory = $categoryFactory->createOne(['is_private' => true]);

        $this->secondLevelCategory = $categoryFactory->createOne();
        $this->topLevelCategory->appendNode($this->secondLevelCategory);

        $this->thirdLevelCategory = $categoryFactory->createOne();
        $this->secondLevelCategory->appendNode($this->thirdLevelCategory);
    }

    /** @test */
    public function should_404_when_viewing_inaccessible_category()
    {
        $response = $this->get(Forum::route(self::ROUTE, $this->topLevelCategory));
        $response->assertStatus(404);
    }

    /** @test */
    public function should_404_when_viewing_child_of_inaccessible_category()
    {
        $response = $this->get(Forum::route(self::ROUTE, $this->secondLevelCategory));
        $response->assertStatus(404);
    }

    /** @test */
    public function should_404_when_viewing_distant_child_of_inaccessible_category()
    {
        $response = $this->get(Forum::route(self::ROUTE, $this->thirdLevelCategory));
        $response->assertStatus(404);
    }
}
