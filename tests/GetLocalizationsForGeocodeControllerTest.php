<?php

declare(strict_types=1);

namespace App\Tests;

use App\Client\Geocode\GeocodeProviderClientInterface;
use App\Controller\GetLocalizationsForGeocodeController;
use App\Model\GeocodeRequest;
use App\Model\Localization;
use App\Response\ApiResponse;
use App\Response\NotFoundApiResponse;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class GetLocalizationsForGeocodeControllerTest extends TestCase
{
    protected $request;
    protected $normalizer;
    protected $client;
    public function setUp(): void
    {
        $this->request = Request::create('api/localizations-for-geocode', 'GET');
        $this->normalizer = $this->createMock(ObjectNormalizer::class);
        $this->client = $this->createMock(GeocodeProviderClientInterface::class);

        $this->normalizer->expects($this->once())
            ->method('denormalize')
            ->with([], GeocodeRequest::class)
            ->willReturn(new GeocodeRequest(''));

        $this->client->expects($this->once())
            ->method('geocode')
            ->willReturn([]);
    }
    public function testInvokeWithEmptyGeocodeRequest(): void
    {
        $controller = new GetLocalizationsForGeocodeController();

        $response = $controller($this->request, $this->normalizer, $this->client);

        $this->assertInstanceOf(NotFoundApiResponse::class, $response);

        $this->assertEquals(['code' => 'not_found'], $response->getErrors());
    }
}
