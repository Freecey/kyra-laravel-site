<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class ConvertImagesToWebp extends Command
{
    protected $signature = 'images:webp
                            {--dir=public/images : Répertoire source des images}
                            {--quality=85 : Qualité WebP (1-100)}
                            {--force : Reconvertir même si le fichier WebP existe déjà}';

    protected $description = 'Convertit les images PNG/JPG/JPEG en WebP optimisé';

    public function handle(): int
    {
        $dir     = base_path($this->option('dir'));
        $quality = (int) $this->option('quality');
        $force   = $this->option('force');

        if (! is_dir($dir)) {
            $this->error("Répertoire introuvable : {$dir}");
            return self::FAILURE;
        }

        $manager = new ImageManager(new Driver());

        $files = glob("{$dir}/*.{png,jpg,jpeg,PNG,JPG,JPEG}", GLOB_BRACE);

        if (empty($files)) {
            $this->warn('Aucune image PNG/JPG trouvée dans ' . $dir);
            return self::SUCCESS;
        }

        $converted = 0;
        $skipped   = 0;

        foreach ($files as $source) {
            $webpPath = preg_replace('/\.(png|jpg|jpeg)$/i', '.webp', $source);

            if (! $force && file_exists($webpPath)) {
                $this->line("  <fg=yellow>SKIP</>  " . basename($source) . " (WebP existe déjà)");
                $skipped++;
                continue;
            }

            try {
                $sizeBefore = filesize($source);

                $manager->decode($source)
                    ->encode(new WebpEncoder($quality))
                    ->save($webpPath);

                $sizeAfter = filesize($webpPath);
                $saving    = round((1 - $sizeAfter / $sizeBefore) * 100);

                $this->line(sprintf(
                    "  <fg=green>OK</>    %s → %s  (%s → %s, -%d%%)",
                    basename($source),
                    basename($webpPath),
                    $this->formatSize($sizeBefore),
                    $this->formatSize($sizeAfter),
                    $saving
                ));

                $converted++;
            } catch (\Throwable $e) {
                $this->error("  ERREUR  " . basename($source) . " : " . $e->getMessage());
            }
        }

        $this->newLine();
        $this->info("Terminé : {$converted} image(s) converties, {$skipped} ignorée(s).");

        return self::SUCCESS;
    }

    private function formatSize(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1) . 'Mo';
        }
        return round($bytes / 1024, 0) . 'Ko';
    }
}
