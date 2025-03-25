<?php

include APPPATH . 'third_party/fpdf/fpdf.php';
ini_set('memory_limit', '1666666M');

class PDF extends FPDF {

// Page header
    function Header() {

        //get nurse information
        global $conn;
        $img_path = base_url(UPLOAD_PATH . "sitesetting/") . get_CompanyLogo();
        $this->SetFont('Helvetica', 'B', 20);
        $this->SetTextColor(0, 0, 0);
        $this->SetAuthor('Appointment Invoice');
        $this->SetTitle('Appointment Invoice');
        $this->SetFontSize(10);
        $this->SetFont('Helvetica');

        $this->SetXY(7, 10);
        $this->Image($img_path, 85, 5, 50);
    }

// Page footer
    function Footer() {
        $valii = 160;

        $this->SetXY(7, $valii + 100);
        $this->SetFontSize(11);
        $this->Write(5, 'SIGNATURE:');
        $this->Line(60, $valii + 104, 185 - 50, $valii + 104);

        $this->SetXY(134, $valii + 100);
        $this->SetFontSize(11);
        $this->Write(5, ' DATE:');
        $this->SetXY(147, $valii + 100);
        $this->Write(5, date('Y-m-d'));
        $this->Line(148, $valii + 104, 250 - 50, $valii + 104);
    }

}

?>