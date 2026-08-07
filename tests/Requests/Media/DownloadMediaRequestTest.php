<?php

use Carbon\CarbonImmutable;
use NieuwbouwOffice\PhpSdk\Data\Media;
use NieuwbouwOffice\PhpSdk\Requests\Media\DownloadMediaRequest;
use Saloon\Enums\Method;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

function mediaWithUrl(string $url): Media
{
    return new Media(
        uuid: 'f40985b31bf3ef6e78dded76be712c0e',
        filename: '33800-ext-02-appartementen-klein.jpg',
        title: null,
        extension: 'jpg',
        url: $url,
        label: 'Algemeen',
        order: 1,
        created_at: CarbonImmutable::parse('2025-12-02 14:43:30'),
    );
}

it('uses the GET method', function () {
    expect((new DownloadMediaRequest(mediaWithUrl('https://static.nbo.nl/media/x.jpg')))->getMethod())
        ->toBe(Method::GET);
});

it('prefixes protocol-relative urls with https', function () {
    expect((new DownloadMediaRequest(mediaWithUrl('//static.nbo.nl//media/f4/x.jpg')))->resolveEndpoint())
        ->toBe('https://static.nbo.nl//media/f4/x.jpg');
});

it('leaves absolute urls untouched', function () {
    expect((new DownloadMediaRequest(mediaWithUrl('https://static.nbo.nl/media/f4/x.jpg')))->resolveEndpoint())
        ->toBe('https://static.nbo.nl/media/f4/x.jpg');
});

it('sends without the connector so no api token is attached', function () {
    $mockClient = new MockClient([
        DownloadMediaRequest::class => MockResponse::make('binary-image-bytes'),
    ]);

    $request = new DownloadMediaRequest(mediaWithUrl('//static.nbo.nl//media/f4/x.jpg'));
    $request->withMockClient($mockClient);

    $response = $request->send();

    expect($response->body())->toBe('binary-image-bytes')
        ->and($response->getPendingRequest()->headers()->get('Authorization'))->toBeNull();
});
