<?php

namespace NieuwbouwOffice\PhpSdk\Requests\UnitTypes;

use NieuwbouwOffice\PhpSdk\Data\UnitType;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetUnitTypesRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(public string $projectUuid) {}

    public function resolveEndpoint(): string
    {
        return "/projects/{$this->projectUuid}/projectwoningen/";
    }

    /**
     * @return UnitType[]
     */
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(
            fn (array $object) => UnitType::fromResponse($object),
            $response->json('data.objects'),
        );
    }
}
