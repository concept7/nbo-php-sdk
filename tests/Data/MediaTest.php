<?php

use Carbon\CarbonImmutable;
use NieuwbouwOffice\PhpSdk\Data\Media;

it('exposes its properties as readonly public values', function () {
    $createdAt = CarbonImmutable::parse('2025-12-02 14:43:30');

    $media = new Media(
        uuid: 'f40985b31bf3ef6e78dded76be712c0e',
        filename: '33800-ext-02-appartementen-klein.jpg',
        title: null,
        extension: 'jpg',
        url: '//static.nbo.nl//media/f4/f40985b31bf3ef6e78dded76be712c0e/O/33800-ext-02-appartementen-klein.jpg',
        label: 'Algemeen',
        order: 1,
        created_at: $createdAt,
    );

    expect($media->uuid)->toBe('f40985b31bf3ef6e78dded76be712c0e')
        ->and($media->filename)->toBe('33800-ext-02-appartementen-klein.jpg')
        ->and($media->title)->toBeNull()
        ->and($media->extension)->toBe('jpg')
        ->and($media->url)->toBe('//static.nbo.nl//media/f4/f40985b31bf3ef6e78dded76be712c0e/O/33800-ext-02-appartementen-klein.jpg')
        ->and($media->label)->toBe('Algemeen')
        ->and($media->order)->toBe(1)
        ->and($media->created_at)->toBe($createdAt);
});

it('parses Media_Timestamp into a CarbonImmutable via fromResponse()', function () {
    $media = Media::fromResponse([
        'Media_UUId' => 'abc',
        'Media_Filename' => 'image.jpg',
        'Media_Titel' => null,
        'Media_Extensie' => 'jpg',
        'URL' => '//static.nbo.nl/media/ab/abc/O/image.jpg',
        'Label' => 'Algemeen',
        'Volgorde' => '3',
        'Media_Timestamp' => '2025-12-02 14:43:30',
    ]);

    expect($media->created_at)->toBeInstanceOf(CarbonImmutable::class)
        ->and($media->created_at->toDateTimeString())->toBe('2025-12-02 14:43:30')
        ->and($media->order)->toBe(3);
});
