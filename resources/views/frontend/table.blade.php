@extends('frontend.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Fixed Layout
            <small>Blank example to the fixed layout</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Layout</a></li>
            <li class="active">Fixed</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="callout callout-info">
            <h4>Tip!</h4>

            <p>Add the fixed class to the body tag to get this layout. The fixed layout is your best option if your sidebar
                is bigger than your content because it prevents extra unwanted scrolling.</p>
        </div>
        <!-- Default box -->

        <div class="box">
            <div class="box-header">
                <h3 class="box-title">事件列表</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>标题</th>
                        <th>分类</th>
                        <th>状态</th>
                        <th>紧急程度</th>
                        <th>创建时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($eventList as $event)
                    <tr>
                        <td>{{$event->event_title}}</td>
                        <td>{{$event->category->category_name}}</td>
                        <td>{{$event->statuss->name}}</td>
                        <td>{{$event->degrees->name}}</td>
                        <td>{{$event->created_at}}</td>
                    </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->


    </section>
    <!-- /.content -->

@endsection
