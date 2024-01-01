<?php

namespace Domain\Stockage\Presenter;

use Domain\Stockage\Response\CreateStorageResponse;

interface CreateStoragePresenterInterface
{
    public function present(CreateStorageResponse $response);
}