<?php

namespace BigPopcorn\Models\Records;

class User {
  public $id;
  public $email;
  public $password;
  public $name;
  public $lastname;

  public function __construct($id, $email, $password, $name, $lastname) {
    $this->id = $id;
    $this->email = $email;
    $this->password = $password;
    $this->name = $name;
    $this->lastname = $lastname;
  }
}
  