<?php

use League\Fractal;
use FractalResponse\FractalResponse as Response;

require __DIR__ . '/util.php';


class TestFractalResponse extends TestCase
{

  public function testSingleItemIsTransformedCorrectly()
  {
    $item = new Item('foo');
    $response = (new Response($item))->with(new ItemTransformer);

    $serialized = (string) $response->getContent();

    $this->assertSame($serialized, '{"Name":"foo"}');
  }

  public function testCollectionOfItemsAreTransformedCorrectly()
  {
    $items = [ new Item('foo'), new Item('baz') ];
    $response = (new Response($items))->with(new ItemTransformer);

    $serialized = (string) $response->getContent();

    $this->assertSame($serialized, '[{"Name":"foo"},{"Name":"baz"}]');
  }

  public function testThatResponseSerializesToEmptyStringIfNoTransformerIsGiven()
  {
    // Unfortunatelly, in PHP the __toString() method must not throw exceptions,
    // so the possibility to react to the case that no transformer was specified is
    // to return an empty string...
    $item = new Item('foo');
    $response = new Response($item);

    $serialized = (string) $response->getContent();

    $this->assertSame($serialized, '');
  }

}
