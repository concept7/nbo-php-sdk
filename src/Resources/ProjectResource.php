<?php

namespace NieuwbouwOffice\PhpSdk\Resources;

use NieuwbouwOffice\PhpSdk\Requests\Projects\GetProjectRequest;
use NieuwbouwOffice\PhpSdk\Requests\Projects\GetProjectsRequest;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class ProjectResource extends BaseResource
{
    public function list(): Response
    {
        return $this->connector->send(new GetProjectsRequest());
    }

    public function get(string $uuid): Response
    {
        return $this->connector->send(new GetProjectRequest($uuid));
    }
}
