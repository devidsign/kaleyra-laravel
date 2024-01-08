<?php

namespace Idsign\Kaleyra;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use Idsign\Kaleyra\Traits\Company;
use Idsign\Kaleyra\Traits\Upload;
use Idsign\Kaleyra\Traits\WebHook;
use Idsign\Kaleyra\Traits\Room;
use Idsign\Kaleyra\Traits\Sdk;
use Idsign\Kaleyra\Traits\Session;
use Idsign\Kaleyra\Traits\User;
use Illuminate\Support\Facades\Log;

class Kaleyra
{
    use User, Room, Company, WebHook, Sdk, Session, Upload;

    private Client $client;
    private string $url;
    private string $key;
    private $body;
    private bool $log = false;
    private $contents;
    private int $status;
    private array $data = [];

    public function __construct()
    {
        $this->url = config('kaleyra_api.url');
        $this->key = config('kaleyra_api.key');
        $this->log = config('kaleyra_api.logging', false);

        $clientConfig = ['base_uri' => $this->url, 'stream' => true];
        $this->client = new Client($clientConfig);
    }

    private function json($url, $type = "POST", $data = [], $headers = []): bool
    {
        $post['json'] = $data;
        return $this->call($url, $type, $post, array_merge($headers, [
            'Content-type' => 'application/json'
        ]));
    }

    private function multipart($url, $file, $fieldName, $type = "POST"): bool
    {
        $post['multipart'] = [
            [
                "name" => $fieldName,
                "mimeType" => $file->getMimeType(),
                "filename" => $file->getClientOriginalName(),
                "contents" => fopen($file->getRealPath(), "r"),
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
        } catch (ClientException|GuzzleException|ServerException $e) {
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
