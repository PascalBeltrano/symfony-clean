<?php

namespace Tests\Domain\Item\UseCase;

use Domain\Item\Entity\Item;
use Domain\Item\Request\CreateRequest;
use Domain\Item\Response\CreateResponse;
use Domain\Item\UseCase\Create;
use Domain\Item\Validator\CreateRequestValidator;
use Infrastructure\Tests\Repository\ItemRepository;
use PHPUnit\Framework\TestCase;
use stdClass;

class CreateTest extends TestCase
{
    private Create $useCase;

    protected function setUp(): void
    {
        $this->useCase = new Create(new ItemRepository, new CreateRequestValidator);
    }

    private function renewUseCase(): void
    {
        $this->useCase = new Create(new ItemRepository, new CreateRequestValidator);
    }

    public function testIfSuccess(): void
    {
        $object = new stdClass();
        $object->name   = 'Pistolet';
        $object->price  = 10.25;

        $request = CreateRequest::create($object);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(CreateResponse::class, $response);
        $this->assertEquals(CreateResponse::STATUS_SUCCESS, $response->getStatus());
        $this->assertInstanceOf(Item::class, $response->getItem());
        $this->assertNull($response->getErrors());
    }

    public function testIfMissingFields(): void
    {
        $object = new stdClass();
        $object->name   = 'Pistolet';
        
        $request = CreateRequest::create($object);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(CreateResponse::class, $response);
        $this->assertEquals(CreateResponse::STATUS_MISSING_FIELDS, $response->getStatus());
        $this->assertContains('price', $response->getErrors());
        $this->assertCount(1, $response->getErrors());

        $object = new stdClass();
        
        $request = CreateRequest::create($object);
        $response = $this->useCase->execute($request);
        
        $this->assertInstanceOf(CreateResponse::class, $response);
        $this->assertEquals(CreateResponse::STATUS_MISSING_FIELDS, $response->getStatus());
        $this->assertContains('name', $response->getErrors());
        $this->assertContains('price', $response->getErrors());
        $this->assertCount(2, $response->getErrors());
    }

    public function testIfExisting(): void
    {
        $object = new stdClass();
        $object->name   = 'Livre';
        $object->price  = 5.25;
        
        $request = CreateRequest::create($object);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(CreateResponse::class, $response);
        $this->assertEquals(CreateResponse::STATUS_EXISTING, $response->getStatus());
    }

    public function testIfInvalid(): void
    {
        $object = new stdClass();
        $object->name   = 'Livre';
        $object->price  = 0;
        
        $request = CreateRequest::create($object);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(CreateResponse::class, $response);
        $this->assertEquals(CreateResponse::STATUS_INVALID, $response->getStatus());
        $this->assertCount(1, $response->getErrors());

        $this->renewUseCase();

        $object2 = new stdClass();
        $object2->name   = '';
        $object2->price  = 0.25;
        
        $request = CreateRequest::create($object2);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(CreateResponse::class, $response);
        $this->assertEquals(CreateResponse::STATUS_INVALID, $response->getStatus());
        $this->assertCount(1, $response->getErrors());

        $this->renewUseCase();

        $object2 = new stdClass();
        $object2->name   = '';
        $object2->price  = 0;
        
        $request = CreateRequest::create($object2);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(CreateResponse::class, $response);
        $this->assertEquals(CreateResponse::STATUS_INVALID, $response->getStatus());
        $this->assertCount(2, $response->getErrors());
    }
}