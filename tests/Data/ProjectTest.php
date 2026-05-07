<?php

use NieuwbouwOffice\PhpSdk\Data\Project;

it('exposes the four properties as readonly public values', function () {
    $project = new Project(
        uuid: 'abc-123',
        title: 'Project ABC',
        created_at: '2026-01-01T00:00:00Z',
        updated_at: '2026-02-01T00:00:00Z',
    );

    expect($project->uuid)->toBe('abc-123')
        ->and($project->title)->toBe('Project ABC')
        ->and($project->created_at)->toBe('2026-01-01T00:00:00Z')
        ->and($project->updated_at)->toBe('2026-02-01T00:00:00Z');
});
