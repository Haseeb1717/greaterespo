<?php
// Define the frames and their corresponding SVG paths
$frames = array(
    'none' => array(
        'path' => '<polygon points="18.7,6.6 12,13.3 5.3,6.6 4.6,7.3 11.3,14 4.6,20.7 5.3,21.4 12,14.7 18.7,21.4 19.4,20.7 12.7,14 19.4,7.3 "/>',
    ),
    'bottom' => array(
        'path' => '<path d="M22.7,0H1.3C0.6,0,0,0.6,0,1.3v25.3C0,27.4,0.6,28,1.3,28h21.3c0.7,0,1.3-0.6,1.3-1.3V1.3C24,0.6,23.4,0,22.7,0z M23,22c0,0.6-0.5,1-1,1H2c-0.6,0-1-0.5-1-1V2c0-0.6,0.5-1,1-1h20c0.6,0,1,0.5,1,1V22z"/>',
        'label_pos' => 'bottom',
        'label_size' => 3,
        'label_offset' => 0,
        'frame_border' => 1,
    ),
    'top' => array(
        'path' => '<path d="M1.3,28L22.6,28c0.7,0,1.3-0.6,1.3-1.3L24,1.4c0-0.7-0.6-1.3-1.3-1.3L1.4,0C0.7,0,0.1,0.6,0,1.3L0,26.6 C-0.1,27.4,0.5,28,1.3,28z M1,6c0-0.6,0.5-1,1-1L22,5c0.6,0,1,0.5,1,1L23,26c0,0.6-0.5,1-1,1L2,27c-0.6,0-1-0.5-1-1L1,6z"/>',
        'label_pos' => 'top',
        'label_size' => 3,
        'label_offset' => 0,
        'frame_border' => 1,
    ),
    'balloon-bottom' => array(
        'path' => '<path d="M1.3,24l21.3,0c0.7,0,1.3-0.6,1.3-1.3l0-21.3C24,0.6,23.4,0,22.7,0L1.3,0C0.6,0,0,0.6,0,1.3l0,21.3 C0,23.4,0.6,24,1.3,24z M1,2c0-0.6,0.5-1,1-1l20,0c0.6,0,1,0.5,1,1v20c0,0.6-0.5,1-1,1L2,23c-0.6,0-1-0.5-1-1V2z"/><path d="M1,30h22c0.5,0,1-0.4,1-1v-3c0-0.5-0.4-1-1-1H13l-1-1l-1,1H1c-0.5,0-1,0.4-1,1v3C0,29.6,0.4,30,1,30z"/>',
        'label_pos' => 'bottom',
        'label_size' => 3,
        'label_offset' => 2,
        'frame_border' => 1,
    ),
    'balloon-top' => array(
        'path' => '<path d="M22.7,6L1.3,6C0.6,6,0,6.6,0,7.3l0,21.3C0,29.4,0.6,30,1.3,30l21.3,0c0.7,0,1.3-0.6,1.3-1.3l0-21.3 C24,6.6,23.4,6,22.7,6z M23,28c0,0.6-0.5,1-1,1L2,29c-0.6,0-1-0.5-1-1V8c0-0.6,0.5-1,1-1l20,0c0.6,0,1,0.5,1,1V28z"/><path d="M23,0H1C0.4,0,0,0.4,0,1v3c0,0.5,0.4,1,1,1h10l1,1l1-1h10c0.5,0,1-0.4,1-1V1C24,0.4,23.6,0,23,0z"/>',
        'label_pos' => 'top',
        'label_size' => 3,
        'label_offset' => 2,
        'frame_border' => 1,
    ),
    'ribbon-bottom' => array(
        'path' => '<path d="M24,21h-1.7V1.7H1.7V21H0l1,2l-1,2h1v2h22v-2h1l-1-2L24,21z M2,2h20v19v1H2v-1V2z"/>',
        'label_pos' => 'bottom',
        'label_size' => 3,
        'label_offset' => -1,
        'frame_border' => 2,
    ),
    'ribbon-top' => array(
        'path' => '<path d="M0,6h1.7v19.3h20.7V6H24l-1-2l1-2h-1V0H1v2H0l1,2L0,6z M22,25H2V6V5h20v1V25z"/>',
        'label_pos' => 'top',
        'label_size' => 3,
        'label_offset' => -1,
        'frame_border' => 2,
    ),
    'phone' => array(
        'path' => '<path d="M17.6,0H6.4c-1,0-1.8,0.8-1.8,1.8v20.4c0,1,0.8,1.8,1.8,1.8h11.1c1,0,1.8-0.8,1.8-1.8V1.8C19.4,0.8,18.6,0,17.6,0z M11.2,2.3h2.7c0.1,0,0.2,0.1,0.2,0.2S14,2.7,13.9,2.7h-2.7c-0.1,0-0.2-0.1-0.2-0.2S11.1,2.3,11.2,2.3z M10.1,2.3 c0.1,0,0.2,0.1,0.2,0.2s-0.1,0.2-0.2,0.2c-0.1,0-0.2-0.1-0.2-0.2S10,2.3,10.1,2.3z M19,19H5V5h14V19z"/>',
        'label_pos' => 'bottom',
        'label_size' => 4,
        'label_offset' => -4.5,
        'frame_border' => 5,
    ),
    'cine' => array(
        'path' => '<path d="M4.5,4.5L4.5,4.5L4.5,4.5l0,17.2c0,0.3,0.3,0.6,0.6,0.6h13.8c0.3,0,0.6-0.3,0.6-0.6V4.5c0-0.3-0.3-0.6-0.6-0.6H5.1 c-0.3,0-0.6,0.3-0.6,0.6z M19.6,8l-7.4,4.5l7.4,4.5V8z M4.5,8l7.4,4.5L4.5,17.1V8z"/>',
        'label_pos' => 'bottom',
        'label_size' => 3,
        'label_offset' => -3.5,
        'frame_border' => 3,
    )
);

// Retrieve the selected frame based on the query parameter 'frame'
$frame = $_GET['frame'] ?? 'none'; // Default to 'none' if no frame is specified

// Ensure that the requested frame exists in the array, or use the default
if (array_key_exists($frame, $frames)) {
    $frameData = $frames[$frame];
} else {
    $frameData = $frames['none']; // Fallback to default frame if invalid frame is requested
}

// Set the content type to JSON
header('Content-Type: application/json');

// Output the frame data as a JSON response
echo json_encode($frameData);
?>
