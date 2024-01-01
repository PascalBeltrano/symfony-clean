<?php

namespace Interface\Controller\Item;

use Domain\Item\Request\DeleteByIdRequest;
use Domain\Item\UseCase\DeleteById;
use Interface\Presenter\Item\DeleteByIdPresenter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DeleteByIdController
{
    #[Route("/api/item/{id}", name:"api_item_delete", methods: ['DELETE'])]
    public function __invoke(
        int $id,
        Request $request,
        DeleteById $useCase,
    ): JsonResponse
    {
        $request = DeleteByIdRequest::create($id);
        $response = $useCase->execute($request);
        $presenter = new DeleteByIdPresenter();
        return $presenter->present($response);
    }
}