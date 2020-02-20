<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Services\CartService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class OrderController extends Controller
{

  public function __construct()
  {
//    parent::__construct($cartService);
  }

  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return Factory|View
   */
    public function index(Request $request)
    {
      $type = $request->type;
      $time = $request->time;
      $search = $request->search;
      $orders = Order::query()->with('user');
      if (isset($search)) {
        $orders = $orders->orWhereHas('user', function($q) use ($search) {
            $q->where(function($q) use ($search) {
              $q->where('name', 'LIKE', '%' . $search . '%');
            });
          })
          ->orWhere('no', 'LIKE', '%'.$search.'%')
          ->orWhere('created_at', 'LIKE', '%'.$search.'%')
          ->orWhere('ship_data', 'LIKE', '%'.$search.'%');
      } else {
        $search = '';
      }
      if (isset($type)) {
        switch ($type) {
          case Order::SHIP_STATUS_RECEIVED:
            $orders =$orders->where('ship_status', Order::SHIP_STATUS_RECEIVED);
            break;
          case Order::SHIP_STATUS_PENDING:
            $orders =$orders->where('ship_status', Order::SHIP_STATUS_PENDING);
            break;
          case Order::SHIP_STATUS_DELIVERED:
            $orders =$orders->where('ship_status', Order::SHIP_STATUS_DELIVERED);
            break;
          case Order::SHIP_STATUS_PAID:
            $orders =$orders->where('ship_status', Order::SHIP_STATUS_PAID);
            break;
        }
      } else {
        $type = 'all';
      }
      if (isset($time)) {
        switch ($time) {
          case 'year':
            $orders =$orders->where('created_at', '<', Carbon::now())->where('created_at', '>', Carbon::now()->subYear(1));
            break;
          case 'month':
            $orders =$orders->where('created_at', '<', Carbon::now())->where('created_at', '>',  Carbon::now()->subMonth(1));
            break;
          case 'week':
            $orders =$orders->where('created_at', '<', Carbon::now())->where('created_at', '>',  Carbon::now()->subWeek(1));
            break;
        }
      } else {
        $time = 'all';
      }

      $orders = $orders->paginate(20);
      $filters = [
        'type'  => $type,
        'time'  => $time,
        'search'=> $search
      ];

      return view('admin.order.index', compact('orders', 'type', 'filters'));
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
     * @return Factory|View
     */
    public function edit($id)
    {
      $order = Order::find($id);
      return view('admin.order.edit', compact('order'));
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
     * @return RedirectResponse
     */
  public function destroy($id) {
    $order = Order::find($id);
    $order->delete();
    return redirect()->route('admin.store.order.index');
  }

  public function collectionsDestroy(Request $request) {
    Order::destroy($request->id);
    return ['status' => 'success'];
  }
}
