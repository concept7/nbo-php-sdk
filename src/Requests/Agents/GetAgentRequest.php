<?php

namespace NieuwbouwOffice\PhpSdk\Requests\Agents;

use NieuwbouwOffice\PhpSdk\Data\Agent;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetAgentRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public string $projectUuid,
        public string $uuid,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/projects/{$this->projectUuid}/makelaars/{$this->uuid}/";
    }

    public function createDtoFromResponse(Response $response): Agent
    {
        return Agent::fromResponse($response->json('data.object'));
    }
}
