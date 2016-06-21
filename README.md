
A simple and lightweight registry
===========================

Installation
------------
```shell
composer require imj\registry
```

Basic Usage
------------
```php
use Imj\Registry;
$r = new Registry();
$r->set('foo', 'a');
echo $r->get('foo'); // a
echo $r['foo']; // a

$r['bar'] = 'b';
echo $r['bar']; // b
```

lazy load
```php
use Imj\Registry;

class Foo
{
  public function sayHi()
  {
    return 'hi';
  }
}

$r->singleton('foo_class', function($c){
  return new Foo();
});
echo $r->get('foo_class')->sayHi(); // hi
echo $r->foo_class->sayHi(); // hi
```

service register
```php
use Imj\ServiceProviderInterface;
use Imj\Registry;

class LibraryProvider implements ServiceProviderInterface
{
  public function register(Registry $registry)
  {
    $registry->singleton('bar_class', function($c){
      return new Bar();
    });
  }
}

class Bar
{
  public function sayHey()
  {
    return 'hey';
  }
}

$r->register(new LibraryProvider());
echo $r->bar_class->sayHey(); // hey
```

License
------------

licensed under the MIT License - see the `LICENSE` file for details
