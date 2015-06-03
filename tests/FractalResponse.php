<?php

use League\Fractal;
use FractalResponse\FractalResponse as Response;

class TestFractalResponse extends TestCase
{

  public function testSingleItem()
  {
    $item = new Item();
    $response = (new Response($item))->item(new ItemTransformer);

    $serialized = (string) $response->getContent();

    $this->assertEquals($serialized, '{"Foo":"foo"}');
  }

  public function testCollection()
  {
    $items = [ new Item(), new Item() ];
    $response = (new Response($items))->collection(new ItemTransformer);

    $serialized = (string) $response->getContent();

    $this->assertEquals($serialized, '[{"Foo":"foo"},{"Foo":"foo"}]');
  }

}


class Item
{
  public function foo() { return 'foo'; }
}

class ItemTransformer extends Fractal\TransformerAbstract
{
  public function transform(Item $item)
  {
      return [
          'Foo'      => $item->foo(),
      ];
  }
}