<?php

namespace NieuwbouwOffice\PhpSdk\Requests\Projects;

use NieuwbouwOffice\PhpSdk\Data\Project;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetProjectsRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/projects/';
    }

    /**
     * @return Project[]
     */
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(
            fn (array $object) => Project::fromResponse($object),
            $response->json('data.objects'),
        );
    }
}
