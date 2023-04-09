<?php

namespace BigPopcorn\Models\Records;

class PublicationType {
  public $id;
  public $name;

  public function __construct($id, $name) {
    $this->id = $id;
    $this->name = $name;
  }
}
