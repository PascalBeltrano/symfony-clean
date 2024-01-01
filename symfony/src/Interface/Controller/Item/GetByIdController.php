<?php

namespace Interface\Controller\Item;

use Domain\Item\Request\GetByIdRequest;
use Domain\Item\UseCase\GetById;
use Interface\Presenter\Item\GetByIdPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GetByIdController
{
    public function __construct(
        private SerializerInterface $serializer
    )
    {
    }

    #[Route("/api/item/{id}", name:"api_item_get_id", methods: ['GET'])]
    public function __invoke(
        int $id,
        GetById $getById
    ): JsonResponse
    {
        $request = GetByIdRequest::create($id);
        $response = $getById->execute($request);
        $presenter = new GetByIdPresenter($this->serializer);
        return $presenter->present($response);
    }
}