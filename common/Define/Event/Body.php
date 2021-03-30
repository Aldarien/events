<?php
namespace ProVM\Common\Define\Event;

interface Body {
  public function write($data);
  public function read();
}
