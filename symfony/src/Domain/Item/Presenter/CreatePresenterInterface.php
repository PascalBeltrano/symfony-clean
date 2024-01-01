<?php

namespace Domain\Item\Presenter;

use Domain\Item\Response\CreateResponse;

interface CreatePresenterInterface
{
    public function present(CreateResponse $response);
}