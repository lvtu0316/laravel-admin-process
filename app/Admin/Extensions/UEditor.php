<?php

namespace App\Admin\Extensions;

use Encore\Admin\Form\Field;

class UEditor extends Field
{
    public static $js = [
        'laravel-u-editor/ueditor.config.js',
        'laravel-u-editor/ueditor.all.min.js',
        'laravel-u-editor/lang/zh-cn/zh-cn.js',
    ];

    protected $view = 'admin.ueditor';

    public function render()
    {
        $this->script = <<<EOT
        UE.delEditor('$this->id');
        var ue_$this->id = UE.getEditor('$this->id');
        ue_$this->id.ready(function () {
            ue_$this->id.execCommand('serverparam', '_token', '{{ csrf_token() }}');
        });
EOT;
        return parent::render();
    }
}
