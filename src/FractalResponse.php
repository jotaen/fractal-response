<?php

namespace FractalResponse;

use Illuminate\Http\Response;
use League\Fractal;

class FractalResponse extends Response
{

  protected $isSerialized = false;

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
   *  Serializes the response content by using the Transformer
   *
   *  @param Fractal\TransformerAbstract $transformer
   *  @return $this
   */
  public function with(Fractal\TransformerAbstract $transformer)
  {
    $resource = null;
    if (is_array($this->getOriginalContent())) {
      $resource = new Fractal\Resource\Collection($this->getOriginalContent(), $transformer);
    }
    else {
      $resource = new Fractal\Resource\Item($this->getOriginalContent(), $transformer);
    }

    $this->isSerialized = true;
    
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