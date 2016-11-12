<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Library: Import / Export
|--------------------------------------------------------------------------
|
*/
class Import_export {

    private $filepath = "";
    private $handle = "";
    private $column_headers = "";

	public function _construct() {
        $CI = & get_instance();
        
    }
    
    /**
     * PDF Generation
     */
    public function generate_pdf($html,$file_name) {

        include_once APPPATH.'/third_party/mpdf/mpdf.php';
        $mpdf = new mPDF(); 
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->WriteHTML($html);
		return $mpdf->Output($file_name,'D'); //$file_name,'D'

    }



    /**
     * CSV Generation
     */
    public function export_csv($res,$header,$filename)
    {

		$fp = fopen('php://output', 'w');
    	header('Content-type: application/csv');
		header('Content-Disposition: attachment; filename='.$filename);
		fputcsv($fp, $header);		
		foreach($res as $r) {
           fputcsv($fp, $r);
		}
		exit;
    }

    /**
     * Function that parses a CSV file and returns results
     * as an array.
     *
     * @access  public
     * @param   filepath        string  Location of the CSV file
     * @param   column_headers  array   Alternate values that will be used for array keys instead of first line of CSV
     * @param   detect_line_endings  boolean  When true sets the php INI settings to allow script to detect line endings. Needed for CSV files created on Macs.
     * @return  array
     */
    public function get_array($filepath='', $column_headers='', $detect_line_endings=FALSE)
    {

        // If true, auto detect row endings
        if($detect_line_endings){
            ini_set("auto_detect_line_endings", TRUE);
        }

        // If file exists, set filepath
        if(file_exists($filepath))
        {

            $this->_set_filepath($filepath);
        }
        else
        {
            return FALSE;            
        }

        // If column headers provided, set them
        $this->_set_column_headers($column_headers);

        // Open the CSV for reading
        $this->_get_handle();
        
        $row = 0;

        while (($data = fgetcsv($this->handle, 0, ",")) !== FALSE) 
        {   
            // If first row, parse for column_headers
            if($row == 0)
            {
                // If column_headers already provided, use them
                if($this->column_headers)
                {
                    foreach ($this->column_headers as $key => $value)
                    {
                        $column_headers[$key] = trim($value);
                    }
                }
                else // Parse first row for column_headers to use
                {
                    foreach ($data as $key => $value)
                    {
                        $column_headers[$key] = trim($value);
                    }                
                }          
            }
            else
            {
                $new_row = $row - 1; // needed so that the returned array starts at 0 instead of 1
                foreach($column_headers as $key => $value) // assumes there are as many columns as their are title columns
                {
                    $result[$new_row][$value] = trim($data[$key]);
                }
            }
            $row++;
        }
        
 
        $this->_close_csv();

        return $result;
    }

   /**
     * Sets the filepath of a given CSV file
     *
     * @access  private
     * @param   filepath    string  Location of the CSV file
     * @return  void
     */
    private function _set_filepath($filepath)
    {
        $this->filepath = $filepath;
    }

   /**
     * Sets the alternate column headers that will be used when creating the array
     *
     * @access  private
     * @param   column_headers  array   Alternate column_headers that will be used instead of first line of CSV
     * @return  void
     */
    private function _set_column_headers($column_headers='')
    {
        if(is_array($column_headers) && !empty($column_headers))
        {
            $this->column_headers = $column_headers;
        }
    }

   /**
     * Opens the CSV file for parsing
     *
     * @access  private
     * @return  void
     */
    private function _get_handle()
    {
        $this->handle = fopen($this->filepath, "r");
    }

   /**
     * Closes the CSV file when complete
     *
     * @access  private
     * @return  array
     */
    private function _close_csv()
    {
        fclose($this->handle);
    }    

   public function output_file($file, $name, $mime_type='')
    {
     /*
     This function takes a path to a file to output ($file),  the filename that the browser will see ($name) and  the MIME type of the file ($mime_type, optional).
     */
     
     //Check the file premission
     if(!is_readable($file)) die('File not found or inaccessible!');
     
     $size = filesize($file);
     $name = rawurldecode($name);
     
     /* Figure out the MIME type | Check in array */
     $known_mime_types=array(
        "pdf" => "application/pdf",
        "txt" => "text/plain",
        "html" => "text/html",
        "htm" => "text/html",
        "exe" => "application/octet-stream",
        "zip" => "application/zip",
        "doc" => "application/msword",
        "xls" => "application/vnd.ms-excel",
        "ppt" => "application/vnd.ms-powerpoint",
        "gif" => "image/gif",
        "png" => "image/png",
        "jpeg"=> "image/jpg",
        "jpg" =>  "image/jpg",
        "php" => "text/plain"
     );
     
     if($mime_type==''){
         $file_extension = strtolower(substr(strrchr($file,"."),1));
         if(array_key_exists($file_extension, $known_mime_types)){
            $mime_type=$known_mime_types[$file_extension];
         } else {
            $mime_type="application/force-download";
         };
     };
     
     //turn off output buffering to decrease cpu usage
     @ob_end_clean(); 
     
     // required for IE, otherwise Content-Disposition may be ignored
     if(ini_get('zlib.output_compression'))
      ini_set('zlib.output_compression', 'Off');
     
     header('Content-Type: ' . $mime_type);
     header('Content-Disposition: attachment; filename="'.$name.'"');
     header("Content-Transfer-Encoding: binary");
     header('Accept-Ranges: bytes');
     
     /* The three lines below basically make the 
        download non-cacheable */
     header("Cache-control: private");
     header('Pragma: private');
     header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
     
     // multipart-download and download resuming support
     if(isset($_SERVER['HTTP_RANGE']))
     {
        list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
        list($range) = explode(",",$range,2);
        list($range, $range_end) = explode("-", $range);
        $range=intval($range);
        if(!$range_end) {
            $range_end=$size-1;
        } else {
            $range_end=intval($range_end);
        }
        /*
        ------------------------------------------------------------------------------------------------------
        //This application is developed by www.webinfopedia.com
        //visit www.webinfopedia.com for PHP,Mysql,html5 and Designing tutorials for FREE!!!
        ------------------------------------------------------------------------------------------------------
        */
        $new_length = $range_end-$range+1;
        header("HTTP/1.1 206 Partial Content");
        header("Content-Length: $new_length");
        header("Content-Range: bytes $range-$range_end/$size");
     } else {
        $new_length=$size;
        header("Content-Length: ".$size);
     }
     
     /* Will output the file itself */
     $chunksize = 1*(1024*1024); //you may want to change this
     $bytes_send = 0;
     if ($file = fopen($file, 'r'))
     {
        if(isset($_SERVER['HTTP_RANGE']))
        fseek($file, $range);
     
        while(!feof($file) && 
            (!connection_aborted()) && 
            ($bytes_send<$new_length)
              )
        {
            $buffer = fread($file, $chunksize);
            print($buffer); //echo($buffer); // can also possible
            flush();
            $bytes_send += strlen($buffer);
        }
     fclose($file);
     } else
         //If no permissiion
         die('Error - can not open file.');
         //die
        die();
}

 




}