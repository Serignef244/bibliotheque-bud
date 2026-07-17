<?php
$directory = __DIR__ . '/resources/views';

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
$files = [];
foreach ($iterator as $file) {
    if ($file->isFile() && str_ends_with($file->getFilename(), '.blade.php')) {
        $files[] = $file->getPathname();
    }
}

$replacements = [
    'BUD Admin' => 'BiblioSmart Admin',
    'Bibliothèque Numérique BUD' => 'BiblioSmart',
    'Bibliothèque BUD' => 'BiblioSmart',
    'Médiathèque Bud' => 'BiblioSmart',
    'mediatheque-bud.fr' => 'bibliosmart.fr',
    'Universitaire de Dakar' => 'BiblioSmart',
    'Bibliothèque Universitaire de Dakar' => 'BiblioSmart'
];

foreach ($files as $file) {
    $content = file_get_contents($file);
    $newContent = strtr($content, $replacements);
    if ($content !== $newContent) {
        file_put_contents($file, $newContent);
        echo "Updated $file\n";
    }
}
echo "Done.\n";
