<?php

namespace NieuwbouwOffice\PhpSdk\Requests\Units;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetUnitsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(public string $projectUuid) {}

    public function resolveEndpoint(): string
    {
        return "/projects/{$this->projectUuid}/woningen/";
    }
}
