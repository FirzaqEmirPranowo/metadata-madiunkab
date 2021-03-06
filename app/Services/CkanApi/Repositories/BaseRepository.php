<?php

namespace App\Services\CkanApi\Repositories;

use App\Services\CkanApi\Traits\RestApiTrait;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class BaseRepository
{
    use RestApiTrait;

    /**
     * URI Api endpoint
     * @var string
     */
    protected $action_name = '';

    /**
     * Per page, paginated results
     *
     * @var int
     */
    protected $per_page = 15;

    /**
     * @var Client
     */
    protected $client;

    /**
     * Standard Ckan HTTP status codes are used to signal method outcomes.
     *
     * @var array
     */
    protected $status_codes = [
        200 => 'Ok',
        201 => 'OK and new object created (referred to in the Location header)',
        301 => 'Moved Permanently',
        400 => 'Bad Request',
        403 => 'Not Authorized',
        404 => 'Not Found',
        409 => 'Conflict (e.g. name already exists)',
        500 => 'Service Error',
    ];

    /**
     * BaseRepository constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->per_page = config('ckan_api.repositories.per_page', $this->per_page);

        $this->setUri("action/{$this->action_name}_{{METHOD}}");

        $this->client = $client;
    }

    /**
     * Set current uri to use for api calls
     *
     * @param string $uriToSet
     */
    protected function setUri($uriToSet)
    {
        $uri_parts = [];

        $uri_parts[] = 'api';
        $uri_parts[] = config('ckan_api.api_version');
        $uri_parts[] = trim($uriToSet, '/');

        $uri_parts = array_filter($uri_parts);

        $this->uri = implode('/', $uri_parts);
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Convert response to json
     *
     * @param ResponseInterface $response
     * @return mixed
     */
    protected function responseToJson(ResponseInterface $response)
    {
        return json_decode((string)$response->getBody() ?? '[]', true);
    }

    /**
     * Converts data to multipart option for guzzle
     *
     * @param array $data
     * @return array
     */
    protected function dataToMultipart(array $data = [])
    {
        $multipart = [];

        foreach ($data as $name => $contents) {
            $multipart[] = ['name' => $name, 'contents' => $contents];
        }

        return $multipart;
    }

}
