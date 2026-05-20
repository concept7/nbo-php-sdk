<?php

namespace NieuwbouwOffice\PhpSdk\Requests\Units;

use NieuwbouwOffice\PhpSdk\Data\Unit;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetUnitRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public string $projectUuid,
        public string $uuid,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/projects/{$this->projectUuid}/woningen/{$this->uuid}/";
    }

    public function createDtoFromResponse(Response $response): Unit
    {
        return Unit::fromResponse($response->json('data.object'));
    }
}
