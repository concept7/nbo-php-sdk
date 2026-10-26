<?php

namespace NieuwbouwOffice\PhpSdk\Requests\Agents;

use NieuwbouwOffice\PhpSdk\Data\Agent;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetAgentsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(public string $projectUuid) {}

    public function resolveEndpoint(): string
    {
        return "/projects/{$this->projectUuid}/makelaars/";
    }

    /**
     * @return Agent[]
     */
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(
            fn (array $object) => Agent::fromResponse($object),
            $response->json('data.objects'),
        );
    }
}
