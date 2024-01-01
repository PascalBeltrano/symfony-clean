<?php

namespace Domain\Item\Presenter;

use Domain\Item\Response\DeleteByIdResponse;

interface DeleteByIdPresenterInterface
{
    public function present(DeleteByIdResponse $response);
}