<?php

namespace Interface\Controller\Item;

use Domain\Item\Request\UpdateRequest;
use Domain\Item\UseCase\Update;
use Interface\Presenter\Item\UpdatePresenter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UpdateController
{
    #[Route("/api/item/{id}", name:"api_item_put", methods: ['PUT', 'PATCH'])]
    public function __invoke(
        int $id,
        Request $request,
        Update $useCase
    ): JsonResponse
    {
        $json = json_decode($request->getContent());
        $request = UpdateRequest::create($id, $json);
        $response = $useCase->execute($request);
        $presenter = new UpdatePresenter();
        return $presenter->present($response);
    }
}