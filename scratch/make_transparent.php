<?php
$imagePath = 'public/images/logo.png';
if (!file_exists($imagePath)) {
    echo "Logo file not found at: $imagePath\n";
    exit(0);
}

$im = @imagecreatefrompng($imagePath);
if (!$im) {
    echo "Failed to load PNG image (GD might not be enabled or image corrupted)\n";
    exit(0);
}

$width = imagesx($im);
$height = imagesy($im);

// Create transparent truecolor image
$newImg = imagecreatetruecolor($width, $height);
imagealphablending($newImg, false);
imagesavealpha($newImg, true);

$transparentColor = imagecolorallocatealpha($newImg, 0, 0, 0, 127);
imagefill($newImg, 0, 0, $transparentColor);

// Convert white/light gray background to transparent
for ($x = 0; $x < $width; $x++) {
    for ($y = 0; $y < $height; $y++) {
        $rgb = imagecolorat($im, $x, $y);
        $colors = imagecolorsforindex($im, $rgb);
        
        // Threshold for near white colors (e.g. padding borders)
        $threshold = 245; 
        if ($colors['red'] >= $threshold && $colors['green'] >= $threshold && $colors['blue'] >= $threshold) {
            // Leave transparent
        } else {
            $color = imagecolorallocatealpha($newImg, $colors['red'], $colors['green'], $colors['blue'], $colors['alpha']);
            imagesetpixel($newImg, $x, $y, $color);
        }
    }
}

imagepng($newImg, $imagePath);
imagedestroy($im);
imagedestroy($newImg);
echo "Transparent logo generated successfully!\n";
