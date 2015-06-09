<?php

use League\Fractal;


class Item
{
  protected $name;

  function __construct($name) {
    $this->name = $name;
  }

  public function name() {
    return $this->name;
  }
}


class ItemTransformer extends Fractal\TransformerAbstract
{
  public function transform(Item $item)
  {
      return [
          'Name'      => $item->name(),
      ];
  }
}