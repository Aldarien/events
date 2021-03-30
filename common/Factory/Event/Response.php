<?php
namespace ProVM\Common\Factory\Event;

use ProVM\Common\Define\Event\{Request, Response as ResponseInterface};
use ProVM\Common\Alias\Event\{Response as ResponseClass, Body};

class Response {
  public function build(Request $request): ResponseInterface {
    $response = new ResponseClass();
    $response->setRequest($request);
    $body = new Body();
    $response->setBody($body);
    return $response;
  }
}
