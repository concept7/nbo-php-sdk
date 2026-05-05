<?php

namespace NieuwbouwOffice\PhpSdk\Requests\Projects;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetProjectRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(public string $uuid) {}

    public function resolveEndpoint(): string
    {
        return "/projects/{$this->uuid}/";
    }
}
