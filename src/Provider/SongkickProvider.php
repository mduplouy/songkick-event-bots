<?php

namespace App\Provider;

use App\Response\Model\Json\EventCollection;
use App\Response\Model\Json\Venue;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use Soundcharts\ApiClientBundle\Response\ResponseBuilderInterface;
use Symfony\Component\Serializer\SerializerInterface;

class SongkickProvider
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var ResponseBuilderInterface
     */
    private $responseBuilder;

    /**
     * @param ClientInterface          $client
     * @param ResponseBuilderInterface $responseBuilder
     */
    public function __construct(
        ClientInterface $client,
        ResponseBuilderInterface $responseBuilder
    ) {
        $this->client          = $client;
        $this->responseBuilder = $responseBuilder;
    }

    /**
     * @param string $identifier
     * @return EventCollection
     */
    public function getLatestEvents(string $identifier):EventCollection
    {
        return $this->getEventCollection($identifier, 'events_latest');
    }

    /**
     * @param string $identifier
     * @return EventCollection
     */
    public function getHistoryEvents(string $identifier):EventCollection
    {
        return $this->getEventCollection($identifier, 'events_history');
    }

    /**
     * @param string $identifier
     * @return EventCollection
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getEventCollection(string $identifier, string $method): EventCollection
    {

        $uri = sprintf('http://gateway.internal.soundcharts.com/provide/songkick/%s?identifier=%s', $method, $identifier);

        $json = $this->client->request('GET', $uri)->getBody()->getContents();

        /** @var EventCollection $eventCollection */
        $eventCollection = $this->responseBuilder->buildResponse(EventCollection::class, $json);

        return $eventCollection;
    }

    /**
     * @param string $identifier
     * @return Venue
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getVenue(string $identifier): Venue
    {
        $uri = sprintf('http://gateway.internal.soundcharts.com/provide/songkick/venue?identifier=%s', $identifier);

        $json = $this->client->request('GET', $uri)->getBody()->getContents();

        /** @var  Venue $venue */
        $venue = $this->responseBuilder->buildResponse(Venue::class, $json);

        return $venue;
    }
}
