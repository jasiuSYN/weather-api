<?php

declare(strict_types=1);

namespace App\Tests;

use App\Client\Geocode\GeocodeProviderClientInterface;
use App\Controller\GetLocalizationsForGeocodeController;
use App\Model\GeocodeRequest;
use App\Response\NotFoundApiResponse;
use App\Response\SuccessApiResponse;
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
    }
    public function testInvokeWithEmptyGeocodeRequest(): void
    {
        $this->normalizer->expects($this->once())
            ->method('denormalize')
            ->with([], GeocodeRequest::class)
            ->willReturn(new GeocodeRequest(''));

        $this->client->expects($this->once())
            ->method('geocode')
            ->willReturn([]);

        $controller = new GetLocalizationsForGeocodeController();
        $response = $controller($this->request, $this->normalizer, $this->client);

        $this->assertInstanceOf(NotFoundApiResponse::class, $response);

        $this->assertEquals(['code' => 'not_found'], $response->getErrors());
    }

    public function testInvokeWithValidGeocodeRequest(): void
    {
        $geocodeRequest = new GeocodeRequest('localizaton');
        $this->normalizer->expects($this->once())
            ->method('denormalize')
            ->with([], GeocodeRequest::class)
            ->willReturn($geocodeRequest);

        $this->client->expects($this->once())
            ->method('geocode')
            ->with($geocodeRequest)
            ->willReturn(['localizaiton' => 'geocode']);

        $controller = new GetLocalizationsForGeocodeController();
        $response = $controller($this->request, $this->normalizer, $this->client);

        $this->assertInstanceOf(SuccessApiResponse::class, $response);
        $this->assertEquals(200, $response->getHttpStatusCode());
    }
}
