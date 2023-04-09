<?php

namespace BigPopcorn\Models\Records;

class Publication {
  public $id;
  public $uri;
  public $title;
  public $abstract;
  public $content;
  public $publication_date;
  public $authors;
  public $references;
  public $citations;
  public $categories;
  public $type;

  public function __construct($id, $uri, $title, $abstract, $content, $publication_date, $authors, $references, $citations, $categories, $type) {
    $this->id = $id;
    $this->uri = $uri;
    $this->title = $title;
    $this->abstract = $abstract;
    $this->content = $content;
    $this->publication_date = $publication_date;
    $this->authors = $authors;
    $this->references = $references;
    $this->citations = $citations;
    $this->categories = $categories;
    $this->type = $type;
  }
}
