<?php

namespace Tests\Domain\Item\UseCase;

use Domain\Item\Request\DeleteByIdRequest;
use Domain\Item\Response\DeleteByIdResponse;
use Domain\Item\UseCase\DeleteById;
use Infrastructure\Tests\Repository\ItemRepository;
use PHPUnit\Framework\TestCase;

class DeleteByIdTest extends TestCase
{
    private DeleteById $useCase;

    protected function setUp(): void
    {
        $this->useCase = new DeleteById(new ItemRepository);
    }

    public function testIfSuccess(): void
    {
        $idItem = 1;
        $request = DeleteByIdRequest::create($idItem);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(DeleteByIdResponse::class, $response);
        $this->assertEquals(DeleteByIdResponse::STATUS_SUCCESS, $response->getStatus());
        $this->assertNull($response->getErrors());
    }

    public function testNoFound(): void
    {
        $idItem = 0;
        $request = DeleteByIdRequest::create($idItem);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(DeleteByIdResponse::class, $response);
        $this->assertEquals(DeleteByIdResponse::STATUS_NO_FOUND, $response->getStatus());
        $this->assertNull($response->getErrors());
    }
}