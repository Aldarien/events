<?php
namespace ProVM\Common\Service\Event;

use Psr\Container\ContainerInterface as Container;
use Psr\EventDispatcher\EventDispatcherInterface;
use ProVM\Common\Define\Event\Request;
use ProVM\Common\Factory\Event\{Response as ResponseBuilder, Listener};

class Dispatcher implements EventDispatcherInterface {
  protected $container;
  public function __construct(Container $container) {
    $this->container = $container;
  }
  protected $listeners;
  public function register(string $action, callable $listener) {
    $this->listeners[$action] = $listener;
  }
  public function dispatch(object $event) {
    if (!is_a($event, Request::class)) {
      throw new \InvalidArgumentException('Argument passed for dispatch NEEDS to be a ' . Request::class);
    }
    $action = $event->getAction();
    if (!isset($this->listeners[$action])) {
      throw new \InvalidArgumentException($action . ' not set.');
    }
    $response = $this->container->get(ResponseBuilder::class)->build($event);
    return $this->container->get(Listener::class)->build($this->listeners[$action], $event, $response);
  }
}
