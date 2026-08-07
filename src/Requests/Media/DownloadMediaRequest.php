<?php

namespace NieuwbouwOffice\PhpSdk\Requests\Media;

use NieuwbouwOffice\PhpSdk\Data\Media;
use Saloon\Enums\Method;
use Saloon\Http\SoloRequest;

/**
 * Downloads the file a Media DTO points at.
 *
 * Media lives on a separate host and needs no API credentials, so this is a
 * SoloRequest rather than a request against the NieuwbouwOffice connector —
 * sending it through the connector would resolve the API base URL and leak
 * the API token to the file host.
 */
class DownloadMediaRequest extends SoloRequest
{
    protected Method $method = Method::GET;

    public function __construct(public readonly Media $media) {}

    public function resolveEndpoint(): string
    {
        return str_starts_with($this->media->url, '//')
            ? 'https:'.$this->media->url
            : $this->media->url;
    }
}
