<?php

namespace NieuwbouwOffice\PhpSdk\Requests\Projects;

use NieuwbouwOffice\PhpSdk\Data\Project;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetProjectRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(public string $uuid) {}

    public function resolveEndpoint(): string
    {
        return "/projects/{$this->uuid}/";
    }

    public function createDtoFromResponse(Response $response): Project
    {
        return Project::fromResponse($response->json('data.object'));
    }
}
