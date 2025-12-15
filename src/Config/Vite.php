<?php

namespace Eren\CodeIgniterVitePlugin\Config;

use CodeIgniter\Config\BaseConfig;

class Vite extends BaseConfig
{
      /**
       * public/ altındaki build dizini
       * Örn: public/build
       */
      public string $buildDirectory = 'build';

      /**
       * Vite build sonrası manifest genelde: public/build/.vite/manifest.json
       */
      public string $manifestDirectory = '.vite';
      public string $manifestFilename = 'manifest.json';

      /**
       * Dev server URL env adı (opsiyonel)
       * Örn: VITE_DEV_SERVER=http://localhost:5173
       */
      public string $devServerEnv = 'VITE_DEV_SERVER';

      /**
       * Dev server set edilmişse @vite/client otomatik eklensin mi?
       */
      public bool $injectViteClient = true;

      public function devServer(): ?string
      {
            $url = getenv($this->devServerEnv) ?: null;
            $url = is_string($url) ? trim($url) : null;

            if (!$url) {
                  return null;
            }

            return rtrim($url, '/');
      }

      public function manifestPath(): string
      {
            return rtrim(FCPATH, DIRECTORY_SEPARATOR)
                  . DIRECTORY_SEPARATOR . trim($this->buildDirectory, '/\\')
                  . DIRECTORY_SEPARATOR . trim($this->manifestDirectory, '/\\')
                  . DIRECTORY_SEPARATOR . $this->manifestFilename;
      }

      public function buildBase(): string
      {
            // HTML tarafında /build/... gibi basacağız
            return '/' . trim($this->buildDirectory, '/\\');
      }
}
