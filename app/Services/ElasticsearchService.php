<?php

namespace App\Services;

use Elastic\Elasticsearch\ClientBuilder;


class ElasticsearchService
{
    protected $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts([env('ELASTICSEARCH_HOST') . ':' . env('ELASTICSEARCH_PORT')])
            ->build();
    }

    public function index(string $index, array $data) // es will auto generate id
    {
        $params = [
            'index' => $index,
            'body'  => $data
        ];

        return $this->client->index($params);
    }

    public function search(string $index, array $query)
    {
        $params = [
            'index' => $index,
            'body'  => $query // No extra array wrapping
        ];

        return $this->client->search($params);
    }

    public function delete(string $index, string $id)
    {
        $params = [
            'index' => $index,
            'id'    => $id
        ];

        return $this->client->delete($params);
    }

}
