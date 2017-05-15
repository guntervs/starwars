<?php

namespace Drupal\starwars\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\starwars\StarWarsClient;
use Symfony\Component\DependencyInjection\ContainerInterface;

class StarWarsController extends ControllerBase {

  /**
   * @var \Drupal\starwars\StarWarsClient
   */
  private $client;

  /**
   * StarWarsController constructor.
   *
   * @param \Drupal\Core\Routing\RouteProviderInterface $provider
   *   The route provider.
   */
  public function __construct(StarWarsClient $client) {
    $this->client = $client;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('starwars.client')
    );
  }

  /**
   * Show the resources available in the SWAPI.
   *
   * @return array
   */
  public function typeView() {
    $build = [];
    $build['list'] = [
      '#theme' => 'sw_types',
      '#types' => $this->client->getTypes(),
    ];

    return $build;
  }

  public function listView($type = '') {
    $build = [];
    $build['list'] = [
      '#theme' => 'sw_list',
      '#type' => $type,
      '#list' => $this->client->getList($type),
    ];

    return $build;
  }

  public function detailView($type = '', $id = NULL) {
    $build = [];
    $build['detail'] = [
      '#theme' => 'sw_detail',
      '#type' => $type,
      '#detail' => $this->client->getDetail($type, $id),
    ];

    return $build;
  }
}