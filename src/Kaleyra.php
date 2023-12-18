<?php

namespace Idsign\Kaleyra;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Idsign\Kaleyra\Traits\Company;
use Idsign\Kaleyra\Traits\Event;
use Idsign\Kaleyra\Traits\Room;
use Idsign\Kaleyra\Traits\Sdk;
use Idsign\Kaleyra\Traits\Session;
use Idsign\Kaleyra\Traits\User;
use Illuminate\Support\Facades\Log;

class Kaleyra
{
    use User, Room, Company, Event, Sdk, Session;

    private Client $client;
    private mixed $url;
    private mixed $key;
    private $body;
    private bool $log = false;
    private $contents;
    private $status;
    private array $data = [];

    public function __construct()
    {
        $this->url = config('bandyer.url');
        $this->key = config('bandyer.key');

        $clientConfig = ['base_uri' => $this->url, 'stream' => true];
        $this->client = new Client($clientConfig);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function json($url, $type="POST", $data = [], $headers = []): bool
    {
        $post['json'] = $data;
        return $this->call($url, $type, $post, array_merge($headers, [
            'Content-type' => 'application/json'
        ]));
    }

    private function multipart($url, $file, $fieldname, $type="POST"): bool
    {
        $post['multipart'] = [
            [
                "name"=>$fieldname,
                "mimeType"=>$file->getMimeType(),
                "filename"=>$file->getClientOriginalName(),
                "contents"=>fopen($file->getRealPath(),"r"),
            ]
        ];
        return $this->call($url, $type, $post);
    }

    private function query($url, $data = [], $headers = []): bool
    {
        $post['query'] = $data;
        return $this->call($url, "GET", $post, array_merge($headers, [
            'Content-type' => 'application/json'
        ]));
    }

    private function post($url, $data = [])
    {

    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function call($url, $type, $data, $customHeaders = []): bool
    {
        $headers = array_merge($customHeaders, [
            'ApiKey' => $this->key,
        ]);
        $config = array_merge([
            'headers' => $headers,
        ], $data);

        $this->data = [
            'url' => $url,
            'method' => $type,
            'data' => $config
        ];

        try {
            $response = $this->client->request($type, $url, $config);
        } catch (ClientException | ServerException $e) {
            $response = $e->getResponse();
        }
        return $this->getResponse($response);
    }

    private function getResponse($response): bool
    {
        $this->body = $response->getBody();
        $this->status = $response->getStatusCode();
        $this->contents = json_decode($this->body->getContents());
        if ($this->log) {
            Log::error('bandyer:log', [
                'request' => $this->data,
                'response' => json_decode(json_encode($this->contents), true),
                'status' => $this->status,
            ]);
        }
        if (!in_array($this->status, [200, 201])) {
            $error = json_decode(json_encode($this->contents), true);
            Log::error('bandyer:error', $error ?: []);
            return false;
        }
        return true;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getContents()
    {
        return $this->contents;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function enableLog(): void
    {
        $this->log = true;
    }
}
