<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model;
use App\State\TaxeFonciereRequestProcessor;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: "/calculate/taxe-fonciere",
            openapi: new Model\Operation(
                summary: 'Calculate Taxe Fonciere',
                description: 'This operation allows you to calculate the taxe fonciere based on habitable surface and price per square meter',
            ),
            normalizationContext: ['groups' => ['taxe_fonciere_request:read']],
            denormalizationContext: ['groups' => ['taxe_fonciere_request:write']],
            input: TaxeFonciereRequest::class,
            output: TaxeFonciereRequest::class,
            processor: TaxeFonciereRequestProcessor::class
        )
    ]
)]
class TaxeFonciereRequest
{
    #[ApiProperty(
        openapiContext: [
            'type' => 'integer'
        ]
    )]
    #[Groups(['taxe_fonciere_request:write'])]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'integer')]
    #[Assert\NotNull]
    public int $surfaceHabitable;

    #[ApiProperty(
        openapiContext: [
            'type' => 'float'
        ]
    )]
    #[Groups(['taxe_fonciere_request:write'])]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'float')]
    #[Assert\NotNull]
    public float $prixM2;

    #[ApiProperty(
        openapiContext: [
            'type' => 'float'
        ]
    )]
    #[Groups(['taxe_fonciere_request:read'])]
    public float $resultat;

    public function process(): void
    {
        $valeurCadastrale = $this->surfaceHabitable * $this->prixM2;
        $this->resultat = $valeurCadastrale * 0.005; // 0.5% de la valeur cadastrale
    }
}
