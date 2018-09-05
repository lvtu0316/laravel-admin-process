<?php

namespace App\Admin\Controllers;

use App\Models\Assets;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class AssetsController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());

        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Assets::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->created_at();
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Assets::class, function (Form $form) {

            $form->row(function ($row) use ($form)
            {
                $row->width(4)->text('number', '资产编号')->rules('required');
                $row->width(4)->text('name', '资产名称')->rules('required');
                $row->width(4)->text('version', '规格型号')->rules('required');
                $row->width(4)->select('project_id', '所属项目')->options(['1'=>1])->rules('required');
                $row->width(8)->text('conf', '详细配置')->rules('required');
                $row->width(4)->ip('ip', 'IP/ID/PW')->rules('required');
                $row->width(4)->text('position', '安装位置')->rules('required');
                $row->width(4)->date('product_date', '出厂日期')->rules('required');
                $row->width(4)->select('type_id', '设备类型')->options(['1'=>1])->rules('required');
                $row->width(4)->select('category_id', '网络类别')->options(['1'=>1])->rules('required');
                $row->width(4)->select('system_id', '业务系统')->options(['1'=>1])->rules('required');
                $row->width(4)->select('address_id', '存放地点')->options(['1'=>1])->rules('required');
                $row->width(4)->select('person_id', '责任人')->options(['1'=>1])->rules('required');
                $row->width(4)->date('put_time', '入账日期')->rules('required');
                $row->width(4)->date('created_at', '登记日期')->rules('required');
                $row->width(4)->select('user_id', '登记人')->options(['1'=>1])->rules('required');
                $row->width(4)->text('card_number', 'IC卡号')->rules('required');
//                $row->width(4)->select('put_time', '安装位置')->rules('required');
//                $row->width(4)->select('put_time', '安装位置')->rules('required');
//                $row->width(4)->select('put_time', '安装位置')->rules('required');

//                $row->width(4)->date('person_id', 'F. de Nac.')->format('DD/MM/YYYY')->rules('required');

            },  $form);
        });
    }
}
