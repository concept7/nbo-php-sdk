<?php

namespace NieuwbouwOffice\PhpSdk\Requests\UnitTypes;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetUnitTypesRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(public string $projectUuid) {}

    public function resolveEndpoint(): string
    {
        return "/projects/{$this->projectUuid}/projectwoningen/";
    }
}
