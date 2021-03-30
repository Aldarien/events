<?php
namespace ProVM\Common\Alias\Server;

use Psr\Container\ContainerInterface as Container;
use Ratchet\Server\IoServer;
use Psr\EventDispatcher\EventDispatcherInterface as Dispatcher;

class App extends IoServer {
  protected $container;
  public function setContainer(Container $container) {
    $this->container = $container;
  }
  public function getContainer(): Container {
    return $this->container;
  }

  public function add(string $action, callable $call) {
    $this->container->get(Dispatcher::class)->register($action, $call);
  }
}
