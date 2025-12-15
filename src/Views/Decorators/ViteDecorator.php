<?php

namespace Eren\CodeIgniterVitePlugin\Views\Decorators;

use CodeIgniter\View\ViewDecoratorInterface;

class ViteDecorator implements ViewDecoratorInterface
{
      public static function decorate(string $html): string
      {
            if (strpos($html, '@vite') === false) {
                  return $html;
            }

            // @vite(['a','b']) veya @vite("a")
            return preg_replace_callback(
                  '/@vite\s*\(\s*(\[.*?\]|([\'"].*?[\'"]))\s*\)/s',
                  static function ($m) {
                        $arg = trim($m[1] ?? '');

                        // array formu: ['a','b']
                        if (str_starts_with($arg, '[')) {
                              preg_match_all('/([\'"])(.*?)\1/s', $arg, $mm);
                              $entries = $mm[2] ?? [];
                              return function_exists('vite') ? vite($entries) : $m[0];
                        }

                        // string formu: 'resources/js/app.js'
                        if (preg_match('/^([\'"])(.*?)\1$/s', $arg, $sm)) {
                              $entries = [$sm[2]];
                              return function_exists('vite') ? vite($entries) : $m[0];
                        }

                        return $m[0];
                  },
                  $html
            );
      }
}
