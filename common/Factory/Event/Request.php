<?php
namespace ProVM\Common\Factory\Event;

use ProVM\Common\Define\Event\Request as RequestInterface;
use ProVM\Common\Alias\Event\Request as RequestClass;
use ProVM\Common\Alias\Event\Body;

class Request {
  public function build($request_string): RequestInterface {
    $data = json_decode($request_string);
    $request = new RequestClass();
    $request->setAction($data->action);
    $request->setMethod($data->method ?? 'GET');
    $body = new Body();
    $body->write($data->data ?? []);
    $request->setBody($body);
    return $request;
  }
}
