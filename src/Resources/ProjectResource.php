<?php

namespace NieuwbouwOffice\PhpSdk\Resources;

use NieuwbouwOffice\PhpSdk\Data\Project;
use NieuwbouwOffice\PhpSdk\Requests\Projects\GetProjectRequest;
use NieuwbouwOffice\PhpSdk\Requests\Projects\GetProjectsRequest;
use Saloon\Http\BaseResource;

class ProjectResource extends BaseResource
{
    /**
     * @return Project[]
     */
    public function list(): array
    {
        return $this->connector->send(new GetProjectsRequest)->dto();
    }

    public function get(string $uuid): Project
    {
        return $this->connector->send(new GetProjectRequest($uuid))->dto();
    }
}
