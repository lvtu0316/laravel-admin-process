<?php

namespace App\Admin\Controllers;

use App\Admin\Extensions\ExcelExpoter;
use App\Models\Client;
use App\Models\Degree;
use App\Models\Event;

use App\Models\EventCategory;
use App\Models\Role;
use App\Models\RoleUser;
use App\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class EventController extends Controller
{
    use ModelForm;

    protected $status;
    protected $action;
    protected $id;


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

            if (Admin::user()->isAdministrator())
            {

                $content->body($this->grid());
                return;
            }
            else
            {
                $role = Admin::user()->roles;
                $role_slug = $role->pluck('slug')->first();

                $event = new Event();
                $this->status = $event->get_status($role_slug);
                $content->body($this->grid());
                return;
            }

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

            $content->header(trans('admin.header_new_event_list'));
            $content->description('description');
            $this->action = 'edit';
            $this->id = $id;
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
            $this->action = 'new';
            $content->body($this->form());
        });
    }
    public function success_events()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');
            $event = new Event();
            $this->status = $event->get_status('success');
            $content->body($this->success_grid());

        });

    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Event::class, function (Grid $grid) {
            if (!Admin::user()->isAdministrator())
            {

                $grid->model()->where('operate_user_id', '=',Admin::user()->id );
            }
            $grid->disableCreateButton();
            $grid->id('ID')->sortable();

            $grid->column('event_title',trans('admin.title'));
            $grid->category()->category_name(trans('admin.category'));
//            $grid->column('status',trans('admin.status'));
            $grid->statuss()->name('状态');
            $grid->user()->name('请求用户');
            $grid->degrees()->name('紧急程度');


            $grid->created_at(trans('admin.created_at'))->sortable();;

            // filter($callback)方法用来设置表格的简单搜索框
            $grid->filter(function ($filter) {
                // 设置created_at字段的范围查询
                $filter->between('created_at', trans('admin.created_at'))->datetime();
            });
            $fileCouls = ['id', 'event_title', 'category_id', 'event_content' ,'created_at'];
            $deepField = 'category_name';
            $deepId = 'category_id';
            $fileCoulsChina = ['ID','标题','描述','分类','创建时间'];
            $grid->exporter(new ExcelExpoter(null,$fileCouls,$fileCoulsChina,$deepId,$deepField));
            $grid->actions(function ($actions) {

                // 没有`delete-event`权限的角色不显示删除按钮
                if (!Admin::user()->can('delete-event')) {
                    $actions->disableDelete();
                }
            });
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function success_grid()
    {
        return Admin::grid(Event::class, function (Grid $grid) {

            $grid->model()->where('status', '=',$this->status );
            $grid->disableCreateButton();
            $grid->id('ID')->sortable();

            $grid->column('event_title',trans('admin.title'));
            $grid->category()->category_name(trans('admin.category'));
//            $grid->column('status',trans('admin.status'));
            $grid->status()->name(trans('admin.status'));
            $grid->user()->name('请求用户');


            $grid->created_at(trans('admin.created_at'))->sortable();

            // filter($callback)方法用来设置表格的简单搜索框
            $grid->filter(function ($filter) {
                // 设置created_at字段的范围查询
                $filter->between('created_at', trans('admin.created_at'))->datetime();
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
        return Admin::form(Event::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('event_title','标题')->rules('required');
            $options = EventCategory::pluck('category_name','id')->toArray();
            $form->select('category_id','分类')->options($options);
            $form->textarea('event_content','描述');
            $client = Client::first()->pluck('client_name','id')->toArray();
            $form->select('client_id','所属用户')->options($client);
            $form->display('user_id','申请用户')->with(function () {
                return Admin::user()->name;
            });
            $form->hidden('user_id')->value(Admin::user()->id);
            $form->datetime('alarm_time','报警时间');
            $form->ip('ip','报警IP');
            $degrees = Degree::orderBy('id','ASC')->pluck('name','id')->toArray();
            $form->select('degree','紧急程度')->options($degrees);
            if ($this->action == 'new')
            {
                $form->hidden('operate_user_role_id')->value(2);
                $form->hidden('operate_user_id')->value(2);
            }

//            $form->display('created_at', '创建时间');
//            $form->display('updated_at', '更新时间');

            if ($this->action != 'new')
            {
                $operate_user_role_id = Event::where('id',$this->id)->pluck('operate_user_role_id')->first();
                if ($operate_user_role_id != 2)
                {
                    $form->ueditor('solution','解决方案');
                }

                $form->divide();
                $roles = Role::pluck('name','id')->toArray();
                $form->select('operate_user_role_id','角色')->options($roles)->load('operate_user_id', '/api/role_users');

                $form->select('operate_user_id','用户')->options(function ($userid){
                    $data = User::find($userid);
                    return [$data['id']=>$data['name']];
                });
            }

        });
    }
}
