FractalResponse for Laravel
==========================

[![Build Status](https://api.travis-ci.org/jotaen/fractal-response.svg)](https://travis-ci.org/jotaen/fractal-response)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jotaen/fractal-response/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/jotaen/fractal-response/?branch=master)

With FractalReponse you can use [Fractal Transformers](http://fractal.thephpleague.com/) on Laravel Reponse objects.

The `FractalResponse` inherits from `Illuminate\Http\Response`. In addition, you pass your `Leage\Fractal`-transformer to the `with()`-method, so that your response gets automatically serialized the way you wish. This is especially helpful when writing REST services, where you have to provide a defined data structure.


Example:
--------

```PHP
<?php namespace App\Http\Controllers;

use League\Fractal;
use Laravel\Lumen\Routing\Controller as BaseController;

use FractalResponse\FractalResponse as Response;

class Controller extends BaseController
{
    public function showOneBook()
    {
      $book = new Book();
      $response = new Response($book, 200);
      $response->with(new BookTransformer());
      return $response;
    }

    public function showSeveralBooks()
    {
      $books = [ new Book(), new Book() ];
      $response = new Response($books, 200);
      $response->with(new BookTransformer());
      return $response;
    }
}


class Book 
{
  public function title() { return 'Help, i am an elephant!'; }
}

class BookTransformer extends Fractal\TransformerAbstract
{
  public function transform($foo)
  {
      return [
          'Title'      => $foo->title(),
      ];
  }
}
```
