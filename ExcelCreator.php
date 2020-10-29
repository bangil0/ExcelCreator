<?php

/**
 * ExcelCreator class is a simple and easy way to use PHPSpreadsheet in CodeIgniter4.
 * It simplifies some PHPSpreadsheet functionality and still let you
 * access all of PHPSpreadsheet features at once.
 * This class enables you to access commonly-used features of PHPSpreadsheet
 * without have to import each class into your code.
 * Just make an object of this class and you can access classes such as
 * Spreadsheet object itself, the writer, styles, etc.
 * 
 * @package     Library
 * @author      Adnan Zaki
 * @copyright   Wolestech DevTeam
 */

require APPPATH . 'ThirdParty/spreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XLsxReader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XLsxWriter;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;

class ExcelCreator
{
    /**
     * The Spreadsheet object
     * 
     * @var object
     */
    public $spreadsheet;

    /**
     * The Color object
     * 
     * @var object
     */
    public $color;

    /**
     * The Alighment style object
     * 
     * @var object
     */
    public $alignment;

    /**
     * The Border style object
     * 
     * @var object
     */
    public $border;

    /**
     * The Fill style object
     * 
     * @var object
     */
    public $fill;

    /**
     * The Font style object
     * 
     * @var object
     */
    public $font;

    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
        $this->alignment = new Alignment();
        $this->border = new Border();
        $this->color = new Color();
        $this->fill = new Fill();
        $this->font = new Font();
    }

    /**
     * Run the XlsxWriter() object
     * 
     * @param object $spreadsheet -> The Spreadsheet object
     * 
     * @return PhpOffice\PhpSpreadsheet\Writer\Xlsx
     */
    public function writer($spreadsheet)
    {
        return new XlsxWriter($spreadsheet);
    }

    /**
     * Run the XlsxReader() object
     * 
     * @param object $spreadsheet -> The Spreadsheet object
     * 
     * @return PhpOffice\PhpSpreadsheet\Reader\Xlsx
     */
    public function reader($spreadsheet)
    {
        return new XlsxReader($spreadsheet);
    }

    /**
     * A convenient way to apply style to PHPSpreadsheet
     * in a compact and simple code
     * Although there are many functions to set style in PHPSpreadsheet,
     * but it is recommended to apply from array as it has 
     * more simple and readable code
     * 
     * @param array $style
     * @param string $range
     * 
     * @return void
     */
    public function applyStyle($style, $range)
    {
        $styleConfig = new Style();
        $styleConfig->applyFromArray($style);
        $this->spreadsheet->getActiveSheet()->duplicateStyle($styleConfig, $range);
    }

    /**
     * Fill cell value from array
     * 
     * @param array $value
     */
    public function fillCell($value)
    {
        $this->spreadsheet->getActiveSheet()->fromArray($value);
    }

    /**
     * Set column width
     * 
     * @param string $dimension
     * @param int|null $width
     * 
     * @return void
     */
    public function setColumnWidth($dimension, $width = null)
    {
        if($width === null)
        {
            $this->spreadsheet
                ->getActiveSheet()
                ->getColumnDimension($dimension)
                ->setAutoSize(true);
        }
        else 
        {
            $this->spreadsheet
                ->getActiveSheet()
                ->getColumnDimension($dimension)
                ->setWidth($width);
        }
    }

    /**
     * Set default column width
     * 
     * @param int $width
     * 
     * @return void
     */
    public function setDefaultColumnWidth($width)
    {
        $this->spreadsheet
            ->getActiveSheet()
            ->getDefaultColumnDimension()
            ->setWidth($width);
    }

    /**
     * Set multiple columns width
     * Sometimes you would like to make width of some columns
     * in the same size, and this is a short way to do that
     * 
     * @param array $dimensions
     * @param int|null $width
     * 
     * @return void
     */
    public function setMultipleColumnsWidth($dimensions = [], $width = null)
    {
        foreach($dimensions as $val)
        {
            $this->setColumnWidth($val, $width);
        }
    }

    /**
     * Set row height
     * 
     * @param string $dimension
     * @param int $height
     * 
     * @return void
     */
    public function setRowHeight($dimension, $height)
    {
        $this->spreadsheet
            ->getActiveSheet()
            ->getRowDimension($dimension)
            ->setRowHeight($height);
    }

    /**
     * Set default row height
     * 
     * @param int $height
     * 
     * @return void
     */
    public function setDefaultRowHeight($height)
    {
        $this->spreadsheet
            ->getActiveSheet()
            ->getDefaultRowDimension()
            ->setRowHeight($height);
    }

    /**
     * Set multiple rows with the same height
     * 
     * @param string $dimensionRange
     * @param int $height
     * 
     * @return void
     */
    public function setMultipleRowsHeight($dimensionRange, $height)
    {
        $range = explode('-', $dimensionRange);
        for($i = $range[0]; $i <= $range[1]; $i++)
        {
            $this->setRowHeight($i, $height);
        }
    }

    /**
     * Set default font to a worksheet
     * 
     * @param string $font
     * @param int $size
     * 
     * @return void
     */
    public function setDefaultFont($font, $size)
    {
        $this->spreadsheet->getDefaultStyle()
            ->getFont()
            ->setName($font)
            ->setSize($size);
    }
}
