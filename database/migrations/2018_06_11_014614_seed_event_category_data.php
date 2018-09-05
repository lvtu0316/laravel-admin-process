<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedEventCategoryData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categories = [
            [
                'category_name'        => '传真机故障请求',
                'description' => '传真机故障请求',
            ],
            [
                'category_name'        => '业务故障请求',
                'description' => '业务故障请求',
            ],
            [
                'category_name'        => '机房环境故障请求',
                'description' => '机房环境故障请求',
            ],
            [
                'category_name'        => '小型机故障请求',
                'description' => '小型机故障请求',
            ],
        ];

        DB::table('event_categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('event_categories')->truncate();
    }
}
