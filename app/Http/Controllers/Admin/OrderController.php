<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index(Request $request)
    {
      $type = $request->type;
      if (isset($type)) {
        switch ($type) {
          case Order::SHIP_STATUS_RECEIVED:
            $orders = Order::where('ship_status', Order::SHIP_STATUS_RECEIVED)->paginate(20);
            break;
          case Order::SHIP_STATUS_PENDING:
            $orders = Order::where('ship_status', Order::SHIP_STATUS_PENDING)->paginate(20);
            break;
          case Order::SHIP_STATUS_DELIVERED:
            $orders = Order::where('ship_status', Order::SHIP_STATUS_DELIVERED)->paginate(20);
            break;
          case Order::SHIP_STATUS_PAID:
            $orders = Order::where('ship_status', Order::SHIP_STATUS_PAID)->paginate(20);
            break;
          default:
            $orders = Order::paginate(20);
            break;
        }
      } else {
        $orders = Order::paginate(20);
      }

      return view('admin.order.index', compact('orders', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
