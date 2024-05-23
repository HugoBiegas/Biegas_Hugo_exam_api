<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\TaxeFonciereRequest;


class TaxeFonciereRequestProcessor implements ProcessorInterface
{
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if ($data instanceof TaxeFonciereRequest) {
            $data->process();
        }

        return $data;
    }
}
