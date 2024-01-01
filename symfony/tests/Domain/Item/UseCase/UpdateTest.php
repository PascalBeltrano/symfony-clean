<?php

namespace Tests\Domain\Item\UseCase;

use Domain\Item\Entity\Item;
use Domain\Item\Request\UpdateRequest;
use Domain\Item\Response\UpdateResponse;
use Domain\Item\UseCase\Update;
use Domain\Item\Validator\UpdateRequestValidator;
use Infrastructure\Tests\Repository\ItemRepository;
use PHPUnit\Framework\TestCase;
use stdClass;

class UpdateTest extends TestCase
{
    private Update $useCase;
    private ItemRepository $itemRepository;

    protected function setUp(): void
    {
        $this->useCase = new Update(new ItemRepository, new UpdateRequestValidator);
        $this->itemRepository = new ItemRepository;
    }

    private function renewUseCase(): void
    {
        $this->useCase = new Update(new ItemRepository, new UpdateRequestValidator);
    }

    public function testIfSuccess(): void
    {
        $idItem = 1;
        $object = new stdClass();
        $object->name   = 'Pistolet';
        $object->price  = 10.25;

        $oldItem = $this->itemRepository->findById($idItem);

        $request = UpdateRequest::create($idItem, $object);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(UpdateResponse::class, $response);
        $this->assertEquals(UpdateResponse::STATUS_SUCCESS, $response->getStatus());
        $this->assertNull($response->getErrors());
        $this->assertInstanceOf(Item::class, $response->getItem());
        $this->assertEquals(1, $response->getItem()->getId());
        $this->assertNotEquals($oldItem->getName(), $response->getItem()->getName());
        $this->assertNotEquals($oldItem->getPrice(), $response->getItem()->getPrice());

        $idItem = 1;
        $object = new stdClass();
        $object->price  = 10.25;

        $oldItem = $this->itemRepository->findById($idItem);

        $request = UpdateRequest::create($idItem, $object);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(UpdateResponse::class, $response);
        $this->assertEquals(UpdateResponse::STATUS_SUCCESS, $response->getStatus());
        $this->assertNull($response->getErrors());
        $this->assertInstanceOf(Item::class, $response->getItem());
        $this->assertEquals(1, $response->getItem()->getId());
        $this->assertEquals($oldItem->getName(), $response->getItem()->getName());
        $this->assertNotEquals($oldItem->getPrice(), $response->getItem()->getPrice());

        $idItem = 1;
        $object = new stdClass();
        $object->name   = 'Pistolet';

        $oldItem = $this->itemRepository->findById($idItem);
        $request = UpdateRequest::create($idItem, $object);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(UpdateResponse::class, $response);
        $this->assertEquals(UpdateResponse::STATUS_SUCCESS, $response->getStatus());
        $this->assertNull($response->getErrors());
        $this->assertInstanceOf(Item::class, $response->getItem());
        $this->assertEquals(1, $response->getItem()->getId());
        $this->assertNotEquals($oldItem->getName(), $response->getItem()->getName());
        $this->assertEquals($oldItem->getPrice(), $response->getItem()->getPrice());
    }

    public function testIfNoFound(): void
    {
        $idItem = 100;
        $object = new stdClass();
        $object->name   = 'Pistolet';
        $object->price  = 10.25;

        $request = UpdateRequest::create($idItem, $object);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(UpdateResponse::class, $response);
        $this->assertEquals(UpdateResponse::STATUS_NO_FOUND, $response->getStatus());
        $this->assertNull($response->getErrors());
        $this->assertNull($response->getItem());
    }

    public function testIfInvalid(): void
    {
        $idItem = 1;
        $object = new stdClass();
        $object->name   = 'Pistolet';
        $object->price  = 0;
        
        $request = UpdateRequest::create($idItem, $object);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(UpdateResponse::class, $response);
        $this->assertEquals(UpdateResponse::STATUS_INVALID, $response->getStatus());
        $this->assertCount(1, $response->getErrors());

        $this->renewUseCase();

        $idItem = 1;
        $object = new stdClass();
        $object->name   = '';
        $object->price  = 45.25;
        
        $request = UpdateRequest::create($idItem, $object);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(UpdateResponse::class, $response);
        $this->assertEquals(UpdateResponse::STATUS_INVALID, $response->getStatus());
        $this->assertCount(1, $response->getErrors());

        $this->renewUseCase();

        $idItem = 1;
        $object = new stdClass();
        $object->name   = '';
        $object->price  = 0;
        
        $request = UpdateRequest::create($idItem, $object);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(UpdateResponse::class, $response);
        $this->assertEquals(UpdateResponse::STATUS_INVALID, $response->getStatus());
        $this->assertCount(2, $response->getErrors());
    }

    public function testIfNoUniqueName(): void
    {
        $idItem = 2;
        $object = new stdClass();
        $object->name   = 'Radio';
        $object->price  = 10.25;

        $request = UpdateRequest::create($idItem, $object);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(UpdateResponse::class, $response);
        $this->assertEquals(UpdateResponse::STATUS_NO_FOUND, $response->getStatus());
        $this->assertNull($response->getErrors());
        $this->assertNull($response->getItem());
    }
}