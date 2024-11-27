<?php

 private static function _vectSVG($frame, $pixelPerPoint = 4, $outerFrame = 4, $back_color = 0xFFFFFF, $fore_color = 0x000000, $style = false, $saveandprint = false)
{
    include dirname(__FILE__).'/markers.php'; // Assuming markers.php contains necessary data

    // Other style settings
    $watermark = isset($style['optionlogo']) && $style['optionlogo'] !== 'none' ? $style['optionlogo'] : false;
    $setframe = isset($style['frame']) && $style['frame'] !== 'none' ? $style['frame'] : false;

    // Default colors
    $backgroundcolor = $back_color !== 'transparent' ? '#'.str_pad(dechex($back_color), 6, "0", STR_PAD_LEFT) : '#fff';
    $frontcolor = '#'.str_pad(dechex($fore_color), 6, "0", STR_PAD_LEFT);

    // Frame dimensions
    $h = count($frame);
    $w = strlen($frame[0]);

    $qrcodeW = $w * $pixelPerPoint;
    $framemargin = $pixelPerPoint * $outerFrame;

    // If a custom frame is set, adjust the margin
    if ($setframe) {
        $frameunit = $qrcodeW / 24;
        $framemargin = $frameunit * $outerFrame;
    }

    $realimgW = $qrcodeW + $framemargin * 2;
    $frameunit = $realimgW / 24;

    // Add SVG Header if saving and printing
    $output = '';
    if ($saveandprint) {
        $output .= '<?xml version="1.0" encoding="utf-8"?>'."\n".
            '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">'."\n";
    }
    $output .= '<svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" xmlns:xlink="http://www.w3.org/1999/xlink" width="'.$realimgW.'" height="'.$realimgW.'" viewBox="0 0 '.$realimgW.' '.$realimgW.'">'."\n";

    // Apply the frame if set
    if ($setframe) {
        include dirname(__FILE__).'/frames.php'; // Assuming this contains frame data like path, borders, etc.

        $framecolor = isset($style['framecolor']) ? $style['framecolor'] : $frontcolor;
        $frametype = $setframe;

        $frameborder = isset($frames[$frametype]['frame_border']) ? intval($frames[$frametype]['frame_border']) : 1;
        $framespacer = isset($frames[$frametype]['label_size']) ? $frames[$frametype]['label_size'] : 0;
        $frameoffset = isset($frames[$frametype]['label_offset']) ? $frames[$frametype]['label_offset'] : 0;
        $framelabelpos = $frames[$frametype]['label_pos'];
        $offset = $frameunit * $frameoffset;
        $spacerH = $framespacer * $frameunit;

        // Adjust frame positioning
        $framediff = ($frameunit * ($framespacer + $frameoffset + 1)) - 1;
        $backgroundsize = ($realimgW - $frameborder * 2 * $frameunit) * 1.01;
        
        // Apply frame path
        $output .= '<g transform="scale('.$frameunit.')" fill="'.$framecolor.'">' . $frames[$frametype]['path'] . '</g>'."\n";
    }

    // Draw the QR code or picture content
    $output .= '<g fill="'.$frontcolor.'">'."\n";
    
    for ($r = 0; $r < $h; $r++) {
        for ($c = 0; $c < $w; $c++) {
            $x = ($c * $pixelPerPoint) + $framemargin;
            $y = ($r * $pixelPerPoint) + $framemargin;
            if ($frame[$r][$c] == '1') {
                $output .= '<rect x="'.$x.'" y="'.$y.'" width="'.$pixelPerPoint.'" height="'.$pixelPerPoint.'" />'."\n";
            }
        }
    }

    // Close the SVG tags
    $output .= '</g>'."\n";
    $output .= '</svg>'."\n";

    return $output;
}
?>