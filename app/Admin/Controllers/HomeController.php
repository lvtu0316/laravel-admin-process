<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\Monitor;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class HomeController extends Controller
{
    protected $itemid ;

    public function index()
    {

        return Admin::content(function (Content $content) {

            $content->header('运维管理');
            $content->description('监控图表');

//            $content->body(view('charts.bar'));
//            $content->row(Dashboard::title());
            $content->row(function (Row $row) {
               // $this->item(29148,$row);
               // $this->filesystem(30223,$row);

            });

        });

    }


    public function item($itemid,Row $row)
    {
        $this->itemid = $itemid;

            $row->column(4, function (Column $column) {
                $params = [
                    'outputs'=>'extend',
                    'history'=>0,
                    'sortfield'=>"clock",
                    'sortorder'=>"ASC",
                    'time_from'=>time()-0.5*3600,
                    'time_till'=>time(),
                    'itemids'=>$this->itemid,
                    'limit'=>10
                ];
                $result = Monitor::item("history.get",$params);
				
                foreach ($result->result as $k=>$v)
                {
                    $re[$k] = doubleval($v->value);
                    $tm[$k] = '"'.date('y-m-d H:i:s',$v->clock).'"';
                }
                $data = '['.implode(',',$re).']';
                $labels = '['.implode(',',$tm).']';
                $type = "'line'";
                $chart = "line";
                $column->append(view('charts.bar',compact('data','labels','type','chart')));
            });



    }

    public function filesystem($itemid,Row $row)
    {
        $this->itemid = $itemid;

        $row->column(4, function (Column $column) {
            $params = [
                'outputs'=>'extend',
                'history'=>0,
                'sortfield'=>"clock",
                'sortorder'=>"ASC",
                'time_from'=>time()-0.5*3600,
                'time_till'=>time(),
                'itemids'=>$this->itemid,
                'limit'=>10
            ];
            $result = Monitor::item("history.get",$params);
            foreach ($result->result as $k=>$v)
            {
                $re[$k] = doubleval($v->value);
                $tm[$k] = '"'.date('y-m-d H:i:s',$v->clock).'"';
            }
            $data = '['.implode(',',$re).']';
            $labels = '['.implode(',',$tm).']';
            $type = "'bar'";
            $chart = "bar";
            $column->append(view('charts.bar',compact('data','labels','type','chart')));
        });



    }
}
