<?php

ini_set('memory_limit', '1666666M');

class PDF extends FPDF {

    const DPI = 96;
    const MM_IN_INCH = 25.4;
    const A4_HEIGHT = 197;
    const A4_WIDTH = 50;
    // tweak these values (in pixels)
    const MAX_WIDTH = 150;
    const MAX_HEIGHT = 150;

    function pixelsToMM($val) {
        return $val * self::MM_IN_INCH / self::DPI;
    }

    function resizeToFit($imgFilename) {
        list($width, $height) = getimagesize($imgFilename);

        $widthScale = self::MAX_WIDTH / $width;
        $heightScale = self::MAX_HEIGHT / $height;

        $scale = min($widthScale, $heightScale);

        return array(
            round($this->pixelsToMM($scale * $width)),
            round($this->pixelsToMM($scale * $height))
        );
    }

    function centreImage($img) {
        list($width, $height) = $this->resizeToFit($img);

        // you will probably want to swap the width/height
        // around depending on the page's orientation
        $this->Image(
                $img, (self::A4_HEIGHT - $width) / 2, (self::A4_WIDTH - $height) / 2, $width, $height
        );
    }

// Page header
    function Header() {
        //get nurse information
        global $conn;
        $img_path = base_url() . img_path . "/logo.png";
        $this->SetFont('Helvetica', 'B', 20);
        $this->SetTextColor(0, 0, 0);
        $this->SetAuthor('BOULDER');
        $this->SetTitle('BOULDER');


        $this->SetXY(7, 6);
        $this->centreImage($img_path, 8, 5, 35);

        $this->SetXY(24, 30);
        $this->SetFontSize(9);
        $this->Cell(50, 3, 'New Order Form', 'C');
    }

}

?>