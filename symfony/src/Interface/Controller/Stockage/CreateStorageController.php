<?php

namespace Interface\Controller\Stockage;

use Domain\Stockage\Request\CreateStorageRequest;
use Domain\Stockage\UseCase\CreateStorage;
use Interface\Presenter\Stockage\CreateStoragePresenter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreateStorageController
{
    #[Route("/api/storage", name:"api_storage_post", methods: ['POST'])]
    public function __invoke(
        Request $request,
        CreateStorage $useCase,
    ): JsonResponse
    {
        $json = json_decode($request->getContent());
        $request = CreateStorageRequest::create($json);
        $response = $useCase->execute($request);
        $presenter = new CreateStoragePresenter();
        return $presenter->present($response);
    }
}