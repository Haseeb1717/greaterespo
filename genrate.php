<?php

// Include the class containing the _vectSVG function
include_once 'qrapply.php';  // Assuming qrapply.php contains the class QRFrameApplication

// Example input data for the function
$frame = [
    ['1', '1', '1', '0', '0'],
    ['1', '0', '1', '1', '0'],
    ['1', '1', '1', '1', '1'],
    // Add your QR code frame data here
];

// Define options (customize as needed)
$pixelPerPoint = 4;
$outerFrame = 4;
$back_color = 0xFFFFFF;  // White
$fore_color = 0x000000;  // Black
$style = ['frame' => 'classic', 'framecolor' => '#FF0000']; // Example style
$saveandprint = true;

// Call the function to generate the SVG
$output = QRFrameApplication::_vectSVG($frame, $pixelPerPoint, $outerFrame, $back_color, $fore_color, $style, $saveandprint);

// Save the output to a file (e.g., 'output.svg')
file_put_contents('output.svg', $output);

echo "QR code SVG has been generated and saved as 'output.svg'.";
?>
