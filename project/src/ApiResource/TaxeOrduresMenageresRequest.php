<?php
namespace App\ApiResource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model;
use App\State\TaxeOrduresMenageresRequestProcessor;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: "/calculate/taxe-ordures-menageres",
            openapi: new Model\Operation(
                summary: 'Calculate Taxe d\'Enlèvement des Ordures Ménagères',
                description: 'This operation allows you to calculate the taxe d\'enlèvement des ordures ménagères based on the value locative cadastrale',
            ),
            normalizationContext: ['groups' => ['taxe_ordures_menageres_request:read']],
            denormalizationContext: ['groups' => ['taxe_ordures_menageres_request:write']],
            input: TaxeOrduresMenageresRequest::class,
            output: TaxeOrduresMenageresRequest::class,
            processor: TaxeOrduresMenageresRequestProcessor::class
        )
    ]
)]
class TaxeOrduresMenageresRequest
{
    #[ApiProperty(
        openapiContext: [
            'type' => 'float'
        ]
    )]
    #[Groups(['taxe_ordures_menageres_request:write'])]
    #[Assert\NotBlank]
    #[Assert\Type(type: 'float')]
    #[Assert\NotNull]
    public float $valeurLocativeCadastrale;

    #[ApiProperty(
        openapiContext: [
            'type' => 'float'
        ]
    )]
    #[Groups(['taxe_ordures_menageres_request:read'])]
    public float $resultat;

    public function process(): void
    {
        $this->resultat = ($this->valeurLocativeCadastrale * 0.5) * 0.0937; 
    }
}
