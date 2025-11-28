<?php
$width = 400;
$height = 400;
$image = imagecreatetruecolor($width, $height);

// Define colors
$white = imagecolorallocate($image, 255, 255, 255);
$red = imagecolorallocate($image, 220, 0, 0);
$darkRed = imagecolorallocate($image, 139, 0, 0);

// Fill background with white
imagefill($image, 0, 0, $white);

// Draw outer red circle
imagefilledellipse($image, 200, 200, 390, 390, $red);

// Draw inner white circle
imagefilledellipse($image, 200, 200, 330, 330, $white);

// Draw circle border
imageellipse($image, 200, 200, 330, 330, $darkRed);
imageellipse($image, 200, 200, 328, 328, $darkRed);

// Draw star at top
$starCenterX = 200;
$starCenterY = 80;
$starPoints = [];
for ($i = 0; $i < 10; $i++) {
    $angle = ($i * 36 - 90) * M_PI / 180;
    $radius = ($i % 2 == 0) ? 30 : 15;
    $starPoints[] = $starCenterX + $radius * cos($angle);
    $starPoints[] = $starCenterY + $radius * sin($angle);
}
imagefilledpolygon($image, $starPoints, 10, $red);

// Draw shield/badge outline
$shieldPoints = [200, 110, 270, 150, 270, 220, 200, 280, 130, 220, 130, 150];
imagefilledpolygon($image, $shieldPoints, 6, $red);

// Draw white shield inside
$innerShieldPoints = [200, 125, 255, 160, 255, 210, 200, 260, 145, 210, 145, 160];
imagefilledpolygon($image, $innerShieldPoints, 6, $white);

// Add border to shield
imagepolygon($image, $shieldPoints, 6, $darkRed);

// Save as JPG
imagejpeg($image, 'public/logo-polres.jpg', 95);
imagedestroy($image);

echo "Logo polres.jpg created successfully!\n";
?>
