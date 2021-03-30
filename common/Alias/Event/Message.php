<?php
namespace ProVM\Common\Alias\Event;

use Psr\Container\ContainerInterface as Container;
use Psr\EventDispatcher\EventDispatcherInterface as Dispatcher;
use Ratchet\MessageComponentInterface as Component;
use Ratchet\ConnectionInterface as Connection;
use ProVM\Common\Factory\Event\Request as RequestBuilder;

class Message implements Component {
  protected $clients;
  public function __construct($storage) {
    $this->clients = $storage;
  }
  protected $dispatcher;
  public function setDispatcher(Dispatcher $dispatcher) {
    $this->dispatcher = $dispatcher;
    return $this;
  }
  protected $request_builder;
  public function setRequestBuilder(RequestBuilder $builder) {
    $this->request_builder = $builder;
    return $this;
  }

  public function onOpen(Connection $conn) {
    $this->clients->attach($conn);
  }
  public function onMessage(Connection $from, $msg) {
    foreach ($this->clients as $client) {
      if ($client != $from) {
        continue;
      }
      $request = $this->request_builder->build($msg);
      $response = $this->dispatcher->dispatch($request);
      $from->send($response);
    }
  }
  public function onClose(Connection $conn) {
    $this->clients->detach($conn);
  }
  public function onError(Connection $conn, \Exception $e) {
    $conn->send(json_encode($e));
    $conn->close();
  }
}
