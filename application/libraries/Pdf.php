<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Purpose: Loading mPDF for Codeigniter
*/

class Pdf {

	public function _construct() {
        $CI = & get_instance();
        
    }
 
    public function generate_pdf($html,$file_name) {

        include_once APPPATH.'/third_party/mpdf/mpdf.php';
        
        $mpdf = new mPDF(); 

		$mpdf->SetDisplayMode('fullpage');

		$mpdf->WriteHTML($html);

		return $mpdf->Output($file_name,'D'); 

		//exit;
       /* $mode='', $format='A4', $default_font_size=0, $default_font='', $margin_left='', 
        $margin_right='', $margin_top='', $margin_bottom='', $margin_header='', $margin_footer='', $orientation='P'*/
        ///return new mPDF($mode, $format, $default_font_size, $default_font, $margin_left, $margin_right, $margin_top, $margin_bottom, $margin_header, $margin_footer, $orientation);
    }
}