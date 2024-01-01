<?php

namespace Domain\Item\Presenter;

use Domain\Item\Response\UpdateResponse;

interface UpdatePresenterInterface
{
    public function present(UpdateResponse $response);
}