<?php
/*
 * Excel file helper class
 * @verion 1.0.0.0
 * @author Pazarkoski Riste
 * @license GNU Public License
 */
require_once('PHPExcel.php');
require_once(dirname(__FILE__) . '/PHPExcel/IOFactory.php');
//Use Cache for large files
$cacheMethod = PHPExcel_CachedObjectStorageFactory::cache_to_phpTemp;
$cacheSettings = array('memoryCacheSize' => '32MB');
PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

class PhpExcelHelper {
    //@var array store all data from loaded excel file
    public static $excel_data;
    /*     * *********************************************************************************************** 
     *  @method void  class construct method
     * ************************************************************************************************ */
    public function __construct() {
        
    }
    /*     * *********************************************************************************************** 
     *  @method array loads excel data in array
     *  @param string $excel_file_path file path to excel file
     * ************************************************************************************************ */
    public static function load($excel_file_path) {
        try {
            if (!file_exists($excel_file_path)) {
                throw new Exception('File ' . $excel_file_path . ' is missing.');
            }
            else {
                //Read excel data
                $objPHPExcel = PHPExcel_IOFactory::load($excel_file_path);
                $data = $objPHPExcel->getActiveSheet()->toArray(null, true, true, false);
                self::$excel_data = $data;
                if (is_array($data[0])) {
                    if (count($data[0]) > 0) {
                        unset($data[0]);
                    }
                }
                return $data;
            }
            return false;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    /*     * *********************************************************************************************** 
     *  @method mixed import data from excel file
     * ************************************************************************************************ */
    public static function importData($excel_file_path) {
        //First load file
        $data = self::load($excel_file_path);
    }
    /*     * *********************************************************************************************** 
     *  @method array get column names of the excel file 
     * ************************************************************************************************ */
    public static function getColumnsNames() {
        if (count(self::$excel_data) > 0) {
            if (is_array(self::$excel_data[0])) {
                if (count(self::$excel_data) > 0) {
                    return self::$excel_data[0];
                }
            }
        }
        return false;
    }
    /*     * *********************************************************************************************** 
     *  @method array get number of columns in excel file
     * ************************************************************************************************ */
    public static function getColumnCount() {
        if (count(self::$excel_data) > 0) {
            if (is_array(self::$excel_data[0])) {
                return count(self::$excel_data[0]);
            }
        }
        return false;
    }
}

?>