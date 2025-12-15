<?php

use Eren\CodeIgniterVitePlugin\Config\Vite as ViteConfig;

if (!function_exists('vite')) {
      /**
       * @param array<int, string> $entries
       */
      function vite(array $entries): string
      {
            /** @var ViteConfig $cfg */
            $cfg = config(ViteConfig::class);

            // DEV SERVER (opsiyonel)
            $dev = $cfg->devServer();
            if ($dev) {
                  $out = '';

                  if ($cfg->injectViteClient) {
                        $out .= '<script type="module" src="' . $dev . '/@vite/client"></script>' . "\n";
                  }

                  foreach ($entries as $e) {
                        $e = ltrim($e, '/');

                        if (str_ends_with($e, '.css')) {
                              $out .= '<link rel="stylesheet" href="' . $dev . '/' . $e . '">' . "\n";
                        } else {
                              $out .= '<script type="module" src="' . $dev . '/' . $e . '"></script>' . "\n";
                        }
                  }

                  return $out;
            }

            // PROD: manifest'ten çöz
            $manifestPath = $cfg->manifestPath();

            if (!is_file($manifestPath)) {
                  // Üretimde exception fırlatmak daha doğru; ama geliştirmede yorum basmak da iyi.
                  // İstersen burada throw yapabilirsin.
                  return "<!-- Vite manifest not found: {$manifestPath}. Run: npm run build -->\n";
            }

            $manifest = json_decode((string) file_get_contents($manifestPath), true);
            if (!is_array($manifest)) {
                  throw new RuntimeException("Vite manifest JSON invalid: {$manifestPath}");
            }

            $css = [];
            $js = [];
            $seen = [];

            $collect = function (string $key) use (&$collect, &$manifest, &$css, &$js, &$seen, $cfg) {
                  if (isset($seen[$key])) {
                        return;
                  }
                  $seen[$key] = true;

                  if (!isset($manifest[$key])) {
                        throw new RuntimeException("Vite entry not found in manifest: {$key}");
                  }

                  $info = $manifest[$key];

                  // imports (chunk)
                  if (!empty($info['imports']) && is_array($info['imports'])) {
                        foreach ($info['imports'] as $imp) {
                              $collect($imp);
                        }
                  }

                  // css listesi
                  if (!empty($info['css']) && is_array($info['css'])) {
                        foreach ($info['css'] as $c) {
                              $css[$cfg->buildBase() . '/' . ltrim($c, '/')] = true;
                        }
                  }

                  // file
                  if (!empty($info['file']) && is_string($info['file'])) {
                        $file = $info['file'];

                        if (str_ends_with($file, '.js')) {
                              $js[$cfg->buildBase() . '/' . ltrim($file, '/')] = true;
                        } elseif (str_ends_with($file, '.css')) {
                              $css[$cfg->buildBase() . '/' . ltrim($file, '/')] = true;
                        }
                  }
            };

            foreach ($entries as $e) {
                  $collect($e);
            }

            $out = '';
            foreach (array_keys($css) as $href) {
                  $out .= '<link rel="stylesheet" href="' . $href . '">' . "\n";
            }
            foreach (array_keys($js) as $src) {
                  $out .= '<script type="module" src="' . $src . '"></script>' . "\n";
            }

            return $out;
      }
}
