<?php

namespace NieuwbouwOffice\PhpSdk\Requests\Units;

use NieuwbouwOffice\PhpSdk\Data\Unit;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetUnitsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(public string $projectUuid) {}

    public function resolveEndpoint(): string
    {
        return "/projects/{$this->projectUuid}/woningen/";
    }

    /**
     * @return Unit[]
     */
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(
            fn (array $object) => Unit::fromResponse($object),
            $response->json('data.objects'),
        );
    }
}
