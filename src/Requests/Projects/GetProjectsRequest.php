<?php

namespace NieuwbouwOffice\PhpSdk\Requests\Projects;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetProjectsRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/projects/';
    }
}
