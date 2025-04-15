<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class LocaleSyncCommand extends Command
{
    protected $signature = 'locale:sync';
    protected $description = 'Sync missing locale keys to all JSON translation files using the base locale';

    public function handle(): void
    {
        $baseLocale = config('translation.base_language');
        $langPath = base_path('lang');
        $basePath = "{$langPath}/{$baseLocale}.json";

        if (!File::exists($basePath)) {
            $this->error("Base language file {$baseLocale}.json not found in path " . $basePath);
            return;
        }

        $baseTranslations = json_decode(File::get($basePath), true);

        foreach (File::files($langPath) as $file) {
            $filename = $file->getFilename();

            if ($file->getExtension() !== 'json' || $filename === "{$baseLocale}.json") {
                continue;
            }

            $locale = pathinfo($filename, PATHINFO_FILENAME);
            $this->line("→ Syncing {$locale}...");

            $targetTranslations = json_decode(File::get($file->getPathname()), true) ?? [];
            $updated = false;

            foreach ($baseTranslations as $key => $value) {
                if (!array_key_exists($key, $targetTranslations)) {
                    $targetTranslations[$key] = $value;
                    $updated = true;
                }
            }

            if ($updated) {
                ksort($targetTranslations);
                File::put($file->getPathname(), json_encode($targetTranslations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
                $this->info("✓ {$locale} updated.");
            } else {
                $this->info("✓ {$locale} is already up to date.");
            }
        }

        $this->info("Locale sync complete.");
    }
}
