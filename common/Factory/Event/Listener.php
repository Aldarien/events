<?php
namespace ProVM\Common\Factory\Event;

use \ReflectionFunction;
use \ReflectionObject;
use Psr\Container\ContainerInterface as Container;
use ProVM\Common\Define\Event\{Request, Response};

class Listener {
  public function __construct(Container $container) {
    $this->container = $container;
  }
  public function build(callable $call, Request $request, Response $response) {
    $function = false;
    $object = null;
    if (is_string($call)) {
      $ref = new ReflectionFunction($call);
      $params = $ref->getParameters();
      $function = true;
    }
    if (is_object($call)) {
      $ref = new ReflectionObject($call);
      $ref = $ref->getMethod('__invoke');
      $params = $ref->getParameters();
      $object = $call;
    }
    if (is_array($call)) {
      $ref = new ReflectionObject($call[0]);
      $ref = $ref->getMethod($call[1]);
      $params = $ref->getParameters();
      $object = $call[0];
    }
    $invoke_params = [$request, $response];
    foreach ($params as $param) {
      if ($param->getName() == 'request' or $param->getName() == 'response') {
        continue;
      }
      if ($param->getType() and $this->container->has($param->getType()->getName())) {
        $invoke_params []= $this->container->get($param->getType()->getName());
        continue;
      }
      if ($param->getType() and class_exists($param->getType()->getName())) {
        $class = $param->getType()->getName();
        $invoke_params []= new $class();
        continue;
      }
      if ($param->isDefaultValueAvailable()) {
        $invoke_params []= $param->getDefaultValue();
        continue;
      }
    }
    if ($function) {
      return json_encode($ref->invokeArgs($invoke_params));
    }
    return json_encode($ref->invokeArgs(new $object(), $invoke_params));
  }
}
