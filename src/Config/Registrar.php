<?php

namespace Eren\CodeIgniterVitePlugin\Config;

use Eren\CodeIgniterVitePlugin\Views\Decorators\ViteDecorator;

class Registrar
{
      /**
       * Config\View için kayıt.
       * Method adı "View" olmalı.
       */
      public static function View(): array
      {
            return [
                  'decorators' => [
                        ViteDecorator::class,
                  ],
            ];
      }
}
