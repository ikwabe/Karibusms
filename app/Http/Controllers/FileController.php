<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\File;
use Request;
use Excel;
use DB;

/**
 * 
 * ----------------------------------------
 * INETS company Limited
 * ---------------------------------------
 * 
 * 
 * @author Ephraim Swilla <ephraim@inetstz.com>
 */
class FileController extends Controller {

    /**
     *
     * @var String;
     * 		     Return name of a file uploaded
     * 		    This will be a unique name based
     * 		     on time() function 
     */
    public $name;

    /**
     *
     * @var Integer: 
     *            This will return a file size in terms of bytes 
     */
    public $size;

    /**
     *
     * @var String:
     * 		     This is a location where such file will be uploaded.
     * 		     you MUST BE set this parameter before you upload a file.
     * 		    The location path is from folder storage/.....
     */
    public $location;

    /**
     *
     * @var String:
     *            This return a file mime type. Example Application/pdf
     *       
     */
    public $mimetype;

    /**
     *
     * @var String:
     * 		    While $location gives a path from a folder storage/..., $path
     * 		    will return a full path from a root folder of your application 
     */
    public $path;

    /**
     *
     * @var String Caption: 
     *                 This is the description about this file. Example description for
     *                 a picture taken 
     */
    public $caption;

    /**
     *
     * @var Integer : Specify webpart ID, If you specify this, then   
     */
    public $storage_path;

    /**
     *
     * @var Array : Private to store extracted data 
     */
    private $excel_array = [];
    private $accepted_keys = array(
        'phone_number', 'email', 'title', 'firstname', 'lastname', 'country', 'location', 'category', 'organization_name', 'organization_description'
    );

    /**
     * @author Ephraim Swilla <ephraim@inetstz.com>
     * @param String $key : This is the index name of file input
     * @example	    <input type="file" name="xyz"/> 
     * 			      From this, $key="xyz"
     * @return Object
     */
    public function upload($key) {

        $file = Request::file($key);
        //$name=  str_replace('.'.$file->guessClientExtension(), '', $file->getClientOriginalName());
        $this->name = time() . '.' . $file->guessClientExtension();
        $file->move($this->storage_path, $this->name);
        chmod($this->storage_path . $this->name, 0755);
    }

    /**
     * CHECK empty mandatory fields
     */
    private function check_empty_key() {
        if (empty($this->location) || empty($this->filetype_id)) {
            die("Location/filetype_id MUST be Specified first");
        }
    }

    /**
     * 
     * @param Object $obj
     * @param String $name
     * @return Object
     */
    private function accessProtected($obj, $name) {
        $array = (array) $obj;
        $prefix = chr(0) . '*' . chr(0);
        return (object) $array[$prefix . $name];
    }

//xlsb ,
    function loadExcel($filename) {
        return $this->fileload($filename);
        Excel::load($filename, function($reader) {
            // Getting all results

            $reader->each(function($sheet) {
                // Loop through all rows
                $sheet->each(function($row) {

                    $data = $row->all();
                    array_push($this->excel_array, $data);
                });
            });
        });
        return $this->excel_array;
    }

    public function fileload($filename) {
        try {
            $inputFileType = \PHPExcel_IOFactory::identify($filename);
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($filename);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($filename, PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }
        $data = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $keys= array_shift($data);
        $result=[];
        foreach ($data as $value) {
            
            $m=array_combine($keys,$value);
            array_push($result, $m);
        }
        return $result;
    }

    public function getUserFiles($client_id = null) {
        $id = $client_id == NULL ? $this->client_id : $client_id;

        $handle = opendir('media/images/business/' . $id);
        $files = array();
        if ($handle) {

            /* This is the correct way to loop over the directory. */
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    array_push($files, $entry);
                }
            }

            closedir($handle);
        }
        return $files;
    }

    public function deleteFile() {
        $filename = request('file');
        unlink('media/images/business/' . $this->client_id . '/' . $filename);
        echo '1';
    }

    /**
     * 
     * @param int $payment_id
     * @return JSON  {'status' ,'message','price','file'}

     */
    public function generateInvoiceFile($payment_id) {
        $payment = DB::table('payment')
                        ->where('payment_id', $payment_id)->first();
        $paymentController = new PaymentController();
        $quantity = $payment->amount / $payment->cost_per_sms;
        return $paymentController->getInvoice($quantity, $payment_id);
    }

    public function generateReceiptFile($payment_id) {
        
    }

    /**
     * 
     * @param String/Int $file
     * @return File Response
     */
    public function downloadFile($file = null) {
        if (request('tag') != NULL && request('tag') == 'invoice') {

            $data = $this->generateInvoiceFile($file);
            $filelink = json_decode($data)->file;
        } else if (request('tag') != NULL && request('tag') == 'receipt') {
            $data = $this->generateReceiptFile($file);
            $filelink = json_decode($data)->file;
        } else {
            $filelink = $file;
        }
        $filepath = __DIR__ . '/../../../media/images/business/' . $this->client_id . '/' . $filelink;
        return response()->download($filepath);
    }

    public static function showFile($file, $client_id) {
        $filepath = __DIR__ . '/../../../media/images/business/' . $client_id . '/' . $file;
        return $filepath;
    }

}
