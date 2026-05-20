<?php

namespace NieuwbouwOffice\PhpSdk\Requests\Media;

use NieuwbouwOffice\PhpSdk\Data\Media;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetMediaRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(public Request $parent) {}

    public function resolveEndpoint(): string
    {
        return rtrim($this->parent->resolveEndpoint(), '/').'/media/';
    }

    /**
     * @return Media[]
     */
    public function createDtoFromResponse(Response $response): array
    {
        return array_map(
            fn (array $object) => Media::fromResponse($object),
            $response->json('data.objects'),
        );
    }
}
