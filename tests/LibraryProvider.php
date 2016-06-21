<?php
namespace Imj\test;

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