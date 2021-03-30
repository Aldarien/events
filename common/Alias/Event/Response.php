<?php
namespace ProVM\Common\Alias\Event;

use ProVM\Common\Define\Event\{Response as ResponseInterface, Request, Body};

class Response implements ResponseInterface {
  protected $request;
  public function setRequest(Request $request) {
    $this->request = $request;
  }
  protected $body;
  public function setBody(Body $body) {
    $this->body = $body;
  }
  public function getRequest(): Request {
    return $this->request;
  }
  public function getBody(): Body {
    return $this->body;
  }
  public function jsonSerialize() {
    return [
      'request' => $this->request->jsonSerialize(),
      'body' => $this->body->read()
    ];
  }
}
