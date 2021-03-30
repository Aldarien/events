<?php
namespace ProVM\Common\Alias\Event;

use ProVM\Common\Define\Event\Body as BodyInterface;

class Body implements BodyInterface {
  protected $body = [];
  public function write($data) {
    if (is_object($data)) {
      return $this->write((array) $data);
    }
    if (!is_array($data)) {
      $this->body []= $data;
      return;
    }
    foreach ($data as $key => $line) {
      $this->body[$key] = $line;
    }
  }
  public function read() {
    return $this->body;
  }
}
