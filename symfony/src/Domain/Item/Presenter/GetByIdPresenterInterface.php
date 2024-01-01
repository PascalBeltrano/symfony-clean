<?php

namespace Domain\Item\Presenter;

use Domain\Item\Response\GetByIdResponse;

interface GetByIdPresenterInterface
{
    public function present(GetByIdResponse $response);
}