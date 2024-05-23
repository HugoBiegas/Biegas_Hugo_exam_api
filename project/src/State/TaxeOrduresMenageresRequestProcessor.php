<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\ApiResource\TaxeOrduresMenageresRequest;

class TaxeOrduresMenageresRequestProcessor implements ProcessorInterface
{
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if ($data instanceof TaxeOrduresMenageresRequest) {
            $data->process();
        }

        return $data;
    }
}
