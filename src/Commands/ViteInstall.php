<?php

namespace Eren\CodeIgniterVitePlugin\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ViteInstall extends BaseCommand
{
      protected $group = 'Vite';
      protected $name = 'vite:install';
      protected $description = 'Scaffold Vite files (resources/, vite.config.mjs) for CodeIgniter 4 project.';
      protected $usage = 'vite:install [--force]';
      protected $options = [
            '--force' => 'Overwrite existing files',
      ];

      public function run(array $params)
      {
            $force = in_array('--force', $params, true);
            $root = rtrim(ROOTPATH, DIRECTORY_SEPARATOR);

            $this->ensureDir($root . '/resources/js');
            $this->ensureDir($root . '/resources/css');

            $this->putFile(
                  $root . '/resources/js/app.js',
                  "alert('Başarıyla kurulum yapıldı');\nconsole.log('Vite ready');\n",
                  $force
            );

            $this->putFile(
                  $root . '/resources/css/app.css',
                  "/* Vite CSS entry */\nbody { background: #f5f5f5; }\n",
                  $force
            );

            // CommonJS projelerde en sorunsuz: vite.config.mjs
            $viteConfig = <<<MJS
import { defineConfig } from "vite";
import { resolve } from "node:path";

export default defineConfig({
  base: "/build/",
  build: {
    outDir: "public/build",
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: {
        app: resolve(__dirname, "resources/js/app.js"),
        style: resolve(__dirname, "resources/css/app.css"),
      },
    },
  },
});
MJS;

            $this->putFile($root . '/vite.config.mjs', $viteConfig . "\n", $force);

            CLI::write('✅ Done!', 'green');
            CLI::write('🚀 Next steps:', 'yellow');

            CLI::write('  1) 📦 Init npm', 'yellow');
            CLI::write('     ➜ npm init -y', 'yellow');

            CLI::write('  2) ⚡ Install Vite', 'yellow');
            CLI::write('     ➜ npm i -D vite', 'yellow');

            CLI::write('  3) 🛠 Add scripts to package.json', 'yellow');
            CLI::write('     ➜ "dev": "vite", "build": "vite build", "watch": "vite build --watch"', 'yellow');

            CLI::write('  4) ▶ Run', 'yellow');
            CLI::write('     ➜ npm run dev   (dev server)', 'yellow');
            CLI::write('     ➜ npm run watch (auto build)', 'yellow');
            CLI::write('     ➜ npm run build (prod)', 'yellow');

            CLI::write('  5) 🧩 Use in CI4 view', 'yellow');
            CLI::write("     ➜ @vite(['resources/css/app.css','resources/js/app.js'])", 'yellow');


      }

      private function ensureDir(string $dir): void
      {
            if (!is_dir($dir)) {
                  mkdir($dir, 0775, true);
            }
      }

      private function putFile(string $path, string $contents, bool $force): void
      {
            if (is_file($path) && !$force) {
                  CLI::write("Skip (exists): {$path}", 'dark_gray');
                  return;
            }

            file_put_contents($path, $contents);
            CLI::write("Created: {$path}", 'green');
      }
}
