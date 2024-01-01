<?php

namespace Tests\Domain\Item\UseCase;

use Domain\Item\Request\GetByIdRequest;
use Domain\Item\Response\GetByIdResponse;
use Domain\Item\UseCase\GetById;
use Infrastructure\Tests\Repository\ItemRepository;
use PHPUnit\Framework\TestCase;

class GetByIdTest extends TestCase
{
    private GetById $useCase;

    protected function setUp(): void
    {
        $this->useCase = new GetById(new ItemRepository);
    }

    public function testIfSuccess(): void
    {
        $id = 1;
        $request = GetByIdRequest::create($id);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(GetByIdResponse::class, $response);
        $this->assertEquals(GetByIdResponse::STATUS_SUCCESS, $response->getStatus());
    }

    public function testIfNoResult(): void
    {
        $id = 100;
        $request = GetByIdRequest::create($id);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(GetByIdResponse::class, $response);
        $this->assertEquals(GetByIdResponse::STATUS_NO_RESULT, $response->getStatus());
        $this->assertNull($response->getItem());
    }
}