<?php

namespace App\Admin\Extensions;

use Encore\Admin\Grid;
use Encore\Admin\Grid\Exporters\AbstractExporter;
use Maatwebsite\Excel\Facades\Excel;

class ExcelExpoter extends AbstractExporter
{
    public $fileCouls;
    public $fileCoulsChina;
    public $filename;
    public $deepField;
    public $deepId;


    public function __construct(Grid $grid = null,$fileCouls,$fileCoulsChina,$deepId,$deepField)
    {
        parent::__construct($grid);
        $this->fileCouls = $fileCouls;
        $this->fileCoulsChina = $fileCoulsChina;
        $this->filename = md5(rand(100000,999999));
        $this->deepField = $deepField;
        $this->deepId = $deepId;
    }

    public function export()
    {
        Excel::create($this->filename, function($excel) {
            $excel->sheet('Sheetname', function($sheet) {
                $sheet->row(1,$this->fileCoulsChina);
                // 这段逻辑是从表格数据中取出需要导出的字段

                $rows = collect($this->getData())->map(function ($item) {
                    if($this->deepField)
                    {
                        //如果是二维数组转一维
                        foreach ($item as $key=>$value)
                        {
                            if (is_array($value) && array_key_exists($this->deepField,$value))
                            {
                                $item[$this->deepId] = $value[$this->deepField];
                            }
                        }
                    }

                    return array_only($item, $this->fileCouls);
                });
//                dd($rows);
                $sheet->rows($rows);

            });

        })->export('xls');
    }


}