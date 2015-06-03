FractalResponse for Laravel
==========================

[![Build Status](https://api.travis-ci.org/jotaen/fractal-response.svg)](https://travis-ci.org/jotaen/fractal-response)

With FractalReponse you can use [Fractal Transformers](http://fractal.thephpleague.com/) on Laravel Reponse objects.

The `FractalResponse` inherits from `Illuminate\Http\Response`, but offers an `item()` and a `collection()` function, where you can pass your `Leage\Fractal`-transformer.


Example:
--------

```PHP
use League\Fractal;
use Laravel\Lumen\Routing\Controller as BaseController;

use FractalResponse\FractalResponse as Response;

class Controller extends BaseController
{
    public function showOneBook()
    {
      $book = new Book();
      return (new Response($book))->item(new BookTransformer());
    }

    public function showSeveralBooks()
    {
      $books = [ new Book(), new Book() ];
      return (new Response($books))->collection(new BookTransformer());
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