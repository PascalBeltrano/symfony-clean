<?php

namespace Interface\Controller\Item;

use Domain\Item\UseCase\GetAll;
use Interface\Presenter\Item\GetAllPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GetAllController
{
    public function __construct(
        private SerializerInterface $serializer
    )
    {
    }
    
    #[Route("/api/item", name:"api_item_get", methods: ['GET'])]
    public function __invoke(
        GetAll $getAll
    ): JsonResponse
    {
        $response = $getAll->execute();
        $presenter = new GetAllPresenter($this->serializer);
        return $presenter->present($response);
    }
}