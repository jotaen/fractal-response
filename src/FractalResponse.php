<?php

namespace FractalResponse;

use Illuminate\Http\Response;
use League\Fractal;

class FractalResponse extends Response
{

  /**
   * Set the content on the response.
   *
   * @param  mixed  $content
   * @return $this
   */
  public function setContent($content)
  {
    $this->original = $content;

    return $this;
  }


  /**
   *  Serializes the response content as single Item by using the Transformer
   *
   *  @param Fractal\TransformerAbstract $transformer
   *  @return $this
   */
  public function item(Fractal\TransformerAbstract $transformer)
  {
    $resource = new Fractal\Resource\Item($this->original, $transformer);
    
    return $this->serialize($resource);   
  }


  /**
   *  Serializes the response content as Collection by using the Transformer
   *
   *  @param Fractal\TransformerAbstract $transformer
   *  @return $this
   */
  public function collection(Fractal\TransformerAbstract $transformer)
  {
    $resource = new Fractal\Resource\Collection($this->original, $transformer);

    return $this->serialize($resource);   
  }


  /**
   *  Serializes the original content
   *
   *  @param Fractal\ResourceAbstract $resource
   *  @return $this
   */
  protected function serialize($resource)
  {
    $manager = new Fractal\Manager();                 
    $data = $manager->createData($resource)->toArray()['data'];
    $serialized = json_encode($data);

    return parent::setContent($serialized);
  }

}