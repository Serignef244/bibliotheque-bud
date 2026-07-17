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
    'text-editorial' => 'text-primary',
    'bg-editorial' => 'bg-secondary',
    'bg-editorial-50' => 'bg-slate-50',
    'bg-editorial-light' => 'bg-blue-500',
    'border-editorial' => 'border-primary',
    'ring-editorial' => 'ring-secondary',
    'from-editorial' => 'from-primary',
    'to-editorial' => 'to-primary',
    'shadow-editorial' => 'shadow-secondary',
    'rounded-full' => 'rounded-xl',
    'font-serif' => 'font-poppins'
];

foreach ($files as $file) {
    $content = file_get_contents($file);
    $newContent = strtr($content, $replacements);
    
    // Also, handle the Google Fonts
    if (str_contains($newContent, 'Playfair+Display')) {
        $newContent = str_replace('family=Playfair+Display:ital,wght@0,400..900;1,400..900&', 'family=Poppins:wght@400;500;600;700&', $newContent);
    }
    
    if ($content !== $newContent) {
        file_put_contents($file, $newContent);
        echo "Updated $file\n";
    }
}
echo "Global string replacement done.\n";
