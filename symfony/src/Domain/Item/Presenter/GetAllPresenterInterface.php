<?php

namespace Domain\Item\Presenter;

use Domain\Item\Response\GetAllResponse;

interface GetAllPresenterInterface
{
    public function present(
        GetAllResponse $response
    );
}