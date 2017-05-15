<?php

namespace Drupal\starwars;

use GuzzleHttp;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class StarWarsClient {

  /**
   * @var \GuzzleHttp\Client
   */
  private $client;

  /**
   * SWAPI URL
   *
   * @var string
   */
  private $baseURL = 'http://swapi.co/api/';

  public function __construct(Client $client) {
    $this->client = $client;
  }

  public function getTypes() {
    /** @var Response $response */
    $response = $this->client->get($this->baseURL);
    $data = GuzzleHttp\json_decode((string) $response->getBody(), TRUE);

    return array_keys($data);
  }

  public function getList($type) {
    /** @var Response $response */
    $response = $this->client->get($this->baseURL . $type . '/');
    $data = GuzzleHttp\json_decode((string) $response->getBody(), TRUE);

    foreach ($data['results'] as &$item) {
      kpr($item);
      die();
      $item['id'] = preg_replace('/[^0-9]/', '', $item['url']);
      if (empty($item['name'])) {
        $item['name'] = $item['title'];
      }
    }

    return $data['results'];

  }

  public function getDetail($type, $id) {
    /** @var Response $response */
    $response = $this->client->get($this->baseURL . $type . '/' . $id . '/');
    $data = GuzzleHttp\json_decode((string) $response->getBody(), TRUE);
    return $data;
  }
}