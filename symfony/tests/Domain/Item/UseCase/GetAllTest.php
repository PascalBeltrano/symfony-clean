<?php

namespace Tests\Domain\Item\UseCase;

use Domain\Item\Entity\Item;
use Domain\Item\Response\GetAllResponse;
use Domain\Item\UseCase\GetAll;
use Infrastructure\Tests\Repository\ItemRepository;
use PHPUnit\Framework\TestCase;

class GetAllTest extends TestCase
{
    private GetAll $useCase;

    protected function setUp(): void
    {
        $this->useCase = new GetAll(new ItemRepository);
    }

    public function testIfSuccess(): void
    {
        $response = $this->useCase->execute();

        $this->assertInstanceOf(GetAllResponse::class, $response);
        $this->assertEquals(GetAllResponse::STATUS_SUCCESS, $response->getStatus());
        $this->assertNull($response->getErrors());
        $this->assertIsArray($response->getItems());

        $items = $response->getItems();
        $this->assertInstanceOf(Item::class, $items[0]);
    }

    public function testIfSuccessButNothing(): void
    {
        $response = $this->useCase->execute();
        $response->setItems(null);

        $this->assertInstanceOf(GetAllResponse::class, $response);
        $this->assertEquals(GetAllResponse::STATUS_SUCCESS, $response->getStatus());
        $this->assertNull($response->getErrors());
        $this->assertNull($response->getItems());
    }
}