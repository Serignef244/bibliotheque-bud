<?php
$src = imagecreatefromjpeg('public/images/logo.jpeg');
$src_w = imagesx($src);
$src_h = imagesy($src);

if (!is_dir('public/icons')) {
    mkdir('public/icons', 0755, true);
}

function resize_and_save($src, $src_w, $src_h, $size, $path) {
    $dst = imagecreatetruecolor($size, $size);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $size, $size, $src_w, $src_h);
    imagepng($dst, $path);
    imagedestroy($dst);
}

// Generate exactly the sizes Apple wants
$sizes = [180, 167, 152, 120];
foreach ($sizes as $s) {
    resize_and_save($src, $src_w, $src_h, $s, "public/icons/icon-{$s}x{$s}.png");
}

imagedestroy($src);
echo "Exact Apple icons generated!\n";
