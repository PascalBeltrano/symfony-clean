<?php

namespace Interface\Presenter\Stockage;

use Domain\Stockage\Presenter\CreateStoragePresenterInterface;
use Domain\Stockage\Response\CreateStorageResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateStoragePresenter implements CreateStoragePresenterInterface
{
    public function present(CreateStorageResponse $response): JsonResponse
    {
        $statusCode=500;
        $content=(object)[];
        $content->message = "Erreur inconnue";

        if($response->isStatusSuccess())
        {
            $statusCode = 200;
            $content->message = "Entrepôt créé avec succès";
        }
        elseif($response->isStatusMissingFields())
        {
            $statusCode = 400;
            $content->message = "Des champs obligatoires sont manquants";
            $content->fields = $response->getErrors();
        }
        elseif($response->isStatusInvalid())
        {
            $statusCode = 400;
            $content->message = "Des valeurs de champs sont invalides";
            $content->fields = $response->getErrors();
        }
        elseif($response->isStatusExisting())
        {
            $statusCode = 400;
            $content->message = "Un Entrepôt avec le même nom existe déjà";
        }

        $jsonResponse=new JsonResponse();
        $jsonResponse->setStatusCode($statusCode);
        $jsonResponse->setData($content);

        return $jsonResponse;
    }
}