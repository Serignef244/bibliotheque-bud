<?php
$src = imagecreatefromjpeg('public/images/logo.jpeg');
$src_w = imagesx($src);
$src_h = imagesy($src);

function resize_and_save($src, $src_w, $src_h, $size, $path) {
    $dst = imagecreatetruecolor($size, $size);
    // iOS wants opaque backgrounds. The logo is already opaque, so just copy resampled.
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $size, $size, $src_w, $src_h);
    imagepng($dst, $path);
    imagedestroy($dst);
}

resize_and_save($src, $src_w, $src_h, 192, 'public/icons/icon-192x192.png');
resize_and_save($src, $src_w, $src_h, 512, 'public/icons/icon-512x512.png');
imagedestroy($src);
echo "Images resized correctly!\n";
