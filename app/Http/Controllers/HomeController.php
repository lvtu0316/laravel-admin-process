<?php
namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use \Illuminate\Http\Request;

class HomeController extends Controller
{
    public function form_page()
    {
        $view = view('welcome');
//        $html = '<html><head><meta charset="utf-8"></head><h1>订单id</h1><h2>12346546</h2></html>';
        $pdf = \PDF::loadHTML($view);
        return $pdf->inline();
//
//        $pdf = App::make('dompdf.wrapper');
//        $pdf->loadHTML('<h1>Test</h1>');
//        return $pdf->stream();
    }
    public function test(Request $request,EventRequest $eventRequest)
    {
        dd($request->post('email'));
    }
    public function table(Event $event)
    {
        $eventList = $event->all();
        return view('frontend.table',compact('eventList'));
    }

}