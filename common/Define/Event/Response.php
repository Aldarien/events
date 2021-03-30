<?php
namespace ProVM\Common\Define\Event;

interface Response extends \JsonSerializable {
  public function setRequest(Request $request);
  public function setBody(Body $body);
  public function getRequest(): Request;
  public function getBody(): Body;
}
