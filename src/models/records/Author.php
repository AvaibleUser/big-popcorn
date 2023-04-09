<?php

namespace BigPopcorn\Models\Records;

class Author {
  public $id;
  public $uri;
  public $name;

  public function __construct($id, $uri, $name) {
    $this->id = $id;
    $this->uri = $uri;
    $this->name = $name;
  }
}
