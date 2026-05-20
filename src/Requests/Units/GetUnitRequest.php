<?php

namespace NieuwbouwOffice\PhpSdk\Requests\Units;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetUnitRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        public string $projectUuid,
        public string $uuid,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/projects/{$this->projectUuid}/woningen/{$this->uuid}/";
    }
}
