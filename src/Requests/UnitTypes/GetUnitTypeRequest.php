<?php

namespace NieuwbouwOffice\PhpSdk\Requests\UnitTypes;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetUnitTypeRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public string $projectUuid,
        public string $uuid,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/projects/{$this->projectUuid}/projectwoningen/{$this->uuid}/";
    }
}
