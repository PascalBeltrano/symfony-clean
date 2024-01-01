<?php

namespace Tests\Domain\Stockage\UseCase;

use Domain\Stockage\Entity\Storage;
use Domain\Stockage\Request\CreateStorageRequest;
use Domain\Stockage\Response\CreateStorageResponse;
use Domain\Stockage\UseCase\CreateStorage;
use Domain\Stockage\Validator\CreateStorageRequestValidator;
use Infrastructure\Tests\Repository\StorageRepository;
use PHPUnit\Framework\TestCase;
use stdClass;

class CreateStorageTest extends TestCase
{
    private CreateStorage $useCase;

    protected function setUp(): void
    {
        $this->useCase = new CreateStorage(new StorageRepository, new CreateStorageRequestValidator);
    }

    private function renewUseCase(): void
    {
        $this->useCase = new CreateStorage(new StorageRepository, new CreateStorageRequestValidator);
    }

    public function testIfSuccess(): void
    {
        $object = new stdClass();
        $object->name = 'Stock Alimentaire - Marseille';
        $object->city = 'Marseille';

        $request = CreateStorageRequest::create($object);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(CreateStorageResponse::class, $response);
        $this->assertEquals(CreateStorageResponse::STATUS_SUCCESS, $response->getStatus());
        $this->assertInstanceOf(Storage::class, $response->getStorage());
        $this->assertNull($response->getErrors());
    }

    public function testIfMissingFields(): void
    {
        $object = new stdClass();
        $object->name = 'Stock Alimentaire - Marseille';

        $request = CreateStorageRequest::create($object);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(CreateStorageResponse::class, $response);
        $this->assertEquals(CreateStorageResponse::STATUS_MISSING_FIELDS, $response->getStatus());
        $this->assertContains('city', $response->getErrors());
        $this->assertCount(1, $response->getErrors());

        $object = new stdClass();
        $object->city = 'Marseille';

        $request = CreateStorageRequest::create($object);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(CreateStorageResponse::class, $response);
        $this->assertEquals(CreateStorageResponse::STATUS_MISSING_FIELDS, $response->getStatus());
        $this->assertContains('name', $response->getErrors());
        $this->assertCount(1, $response->getErrors());

        $object = new stdClass();

        $request = CreateStorageRequest::create($object);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(CreateStorageResponse::class, $response);
        $this->assertEquals(CreateStorageResponse::STATUS_MISSING_FIELDS, $response->getStatus());
        $this->assertContains('name', $response->getErrors());
        $this->assertContains('city', $response->getErrors());
        $this->assertCount(2, $response->getErrors());

    }

    public function testIfExisting(): void
    {
        $object = new stdClass();
        $object->name = 'Stock Alimentaire - Istres';
        $object->city = 'Istres';

        $request = CreateStorageRequest::create($object);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(CreateStorageResponse::class, $response);
        $this->assertEquals(CreateStorageResponse::STATUS_EXISTING, $response->getStatus());
        $this->assertNull($response->getErrors());
    }

    public function testIfInvalid(): void
    {
        $object = new stdClass();
        $object->name = 'Sto';
        $object->city = 'Marseille';

        $request = CreateStorageRequest::create($object);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(CreateStorageResponse::class, $response);
        $this->assertEquals(CreateStorageResponse::STATUS_INVALID, $response->getStatus());
        $this->assertCount(1, $response->getErrors());

        $this->renewUseCase();

        $object = new stdClass();
        $object->name = 'Stock Alimentaire - Marseille';
        $object->city = 'Ma';

        $request = CreateStorageRequest::create($object);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(CreateStorageResponse::class, $response);
        $this->assertEquals(CreateStorageResponse::STATUS_INVALID, $response->getStatus());
        $this->assertCount(1, $response->getErrors());

        $this->renewUseCase();

        $object = new stdClass();
        $object->name = 'St';
        $object->city = 'Ma';

        $request = CreateStorageRequest::create($object);
        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(CreateStorageResponse::class, $response);
        $this->assertEquals(CreateStorageResponse::STATUS_INVALID, $response->getStatus());
        $this->assertCount(2, $response->getErrors());

        $this->renewUseCase();
    }
}