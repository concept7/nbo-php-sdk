<?php

namespace NieuwbouwOffice\PhpSdk\Requests\UnitTypes;

use NieuwbouwOffice\PhpSdk\Data\UnitType;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetUnitTypeRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public string $projectUuid,
        public string $uuid,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/projects/{$this->projectUuid}/projectwoningen/{$this->uuid}/";
    }

    public function createDtoFromResponse(Response $response): UnitType
    {
        return UnitType::fromResponse($response->json('data.object'));
    }
}
