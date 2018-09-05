<?php

namespace App\Admin\Controllers;

use App\Models\Repository;

use App\Models\RepositoryCategory;
use App\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class RepositoryController extends Controller
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
        return Admin::grid(Repository::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('title','主题');
            $grid->category()->name('知识类型');
            $grid->user()->name('作者');

            $grid->file('附件')->display(function ($file)
            {
                $url = config('app.url');
//                return "<a href='/upload/$file' download='聚合运维流程管理计划及功能点.xls'>$file</a>";
                return "<a target='_blank' href='$url/admin/media/download?file=$file' class='file-name' title='$file'>
                Koala.jpg </a>";
            });


            $grid->created_at('创建时间');
            $grid->updated_at('更新时间');

            $grid->filter(function($filter){


                // 在这里添加字段过滤器
                $filter->like('title', '标题');

            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Repository::class, function (Form $form) {
            $categories = RepositoryCategory::all()->pluck('name','id')->toArray();
            $users = User::all()->pluck('name','id')->toArray();
            $states = [
                'on'  => ['value' => Repository::STATUS_ON, 'text' => '发布', 'color' => 'success'],
                'off' => ['value' => Repository::STATUS_OFF, 'text' => '隐藏', 'color' => 'danger'],
            ];
            $form->display('id', 'ID');
            $form->text('title','主题');
            $form->select('repository_category_id','知识类型')->options($categories);
            $form->select('user_id','作者')->options($users);
            $form->ueditor('content','正文内容');
            $form->file('file','附件');
            $form->switch('status','状态')->options($states);


            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
