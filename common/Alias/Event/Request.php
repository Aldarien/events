<?php
namespace ProVM\Common\Alias\Event;

use ProVM\Common\Define\Event\{Request as RequestInterface, Body};

class Request implements RequestInterface {
  protected $action;
  public function setAction(string $action) {
    $this->action = $action;
  }
  protected $method;
  public function setMethod(string $method) {
    $this->method = $method;
  }
  protected $body;
  public function setBody(Body $body) {
    $this->body = $body;
  }
  public function getAction(): string {
    return $this->action;
  }
  public function getMethod(): string {
    return $this->method;
  }
  public function getBody(): Body {
    return $this->body;
  }
  public function jsonSerialize() {
    return [
      'action' => $this->action,
      'method' => $this->method,
      'body' => $this->body->read()
    ];
  }
}
