<?php

namespace Interface\Controller\Item;

use Domain\Item\Request\CreateRequest;
use Domain\Item\UseCase\Create;
use Interface\Presenter\Item\CreatePresenter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreateController
{
    #[Route("/api/item", name:"api_item_post", methods: ['POST'])]
    public function __invoke(
        Request $request, 
        Create $create
    ): JsonResponse
    {
        $json = json_decode($request->getContent());
        $request = CreateRequest::create($json);
        $response = $create->execute($request);
        $presenter = new CreatePresenter();
        return $presenter->present($response);
    }
}