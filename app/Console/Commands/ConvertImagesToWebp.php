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

    protected $description = 'Convertit les images PNG/JPG/JPEG en WebP optimisé + variantes responsives';

    /**
     * Variantes responsives à générer pour certaines images.
     * Clé = nom de fichier source (sans extension), valeur = largeurs en px.
     */
    private array $responsiveVariants = [
        'kyra-full'    => [400, 700],
        'kyra-banner2' => [800, 1400],
    ];

    /**
     * Qualité spécifique par image (surcharge --quality globale).
     */
    private array $qualityOverrides = [
        'kyra-banner2' => 72,
    ];

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
            $basename = pathinfo($source, PATHINFO_FILENAME);
            $q        = $this->qualityOverrides[$basename] ?? $quality;
            $webpPath = preg_replace('/\.(png|jpg|jpeg)$/i', '.webp', $source);

            // ── Fichier WebP principal ──
            if ($force || ! file_exists($webpPath)) {
                try {
                    $sizeBefore = filesize($source);
                    $manager->decode($source)->encode(new WebpEncoder($q))->save($webpPath);
                    $sizeAfter = filesize($webpPath);
                    $saving    = round((1 - $sizeAfter / $sizeBefore) * 100);
                    $this->line(sprintf(
                        "  <fg=green>OK</>    %s → %s  (%s → %s, -%d%%)",
                        basename($source), basename($webpPath),
                        $this->formatSize($sizeBefore), $this->formatSize($sizeAfter), $saving
                    ));
                    $converted++;
                } catch (\Throwable $e) {
                    $this->error("  ERREUR  " . basename($source) . " : " . $e->getMessage());
                }
            } else {
                $this->line("  <fg=yellow>SKIP</>  " . basename($source) . " (WebP existe déjà)");
                $skipped++;
            }

            // ── Variantes responsives ──
            if (isset($this->responsiveVariants[$basename])) {
                foreach ($this->responsiveVariants[$basename] as $width) {
                    $variantPath = "{$dir}/{$basename}-{$width}w.webp";

                    if (! $force && file_exists($variantPath)) {
                        $this->line("  <fg=yellow>SKIP</>  {$basename}-{$width}w.webp (existe déjà)");
                        continue;
                    }

                    try {
                        $manager->decode($source)
                            ->scaleDown(width: $width)
                            ->encode(new WebpEncoder($q))
                            ->save($variantPath);

                        $this->line(sprintf(
                            "  <fg=cyan>RSIZE</>  %s → %s (%s)",
                            basename($source), basename($variantPath),
                            $this->formatSize(filesize($variantPath))
                        ));
                        $converted++;
                    } catch (\Throwable $e) {
                        $this->error("  ERREUR variante {$width}w : " . $e->getMessage());
                    }
                }
            }
        }

        $this->newLine();
        $this->info("Terminé : {$converted} fichier(s) générés, {$skipped} ignoré(s).");

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
