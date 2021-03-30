<?php
namespace ProVM\Common\Define\Event;

use ProVM\Common\Define\Event\Body;

interface Request extends \JsonSerializable {
  public function setAction(string $action);
  public function setMethod(string $method);
  public function setBody(Body $body);
  public function getAction(): string;
  public function getMethod(): string;
  public function getBody(): Body;
}
