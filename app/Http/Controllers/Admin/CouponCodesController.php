<?php

namespace App\Http\Controllers\Admin;

use App\Models\CouponCode;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Models\Category;

class CouponCodesController extends Controller
{

  public function __construct()
  {
//    parent::__construct($cartService);
  }
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index(Request $request)
    {
      $type = $request->type;
      $search = $request->search;
      $coupons = CouponCode::query();
      if (isset($search)) {
        $coupons = $coupons->where('name', 'LIKE', '%'.$search.'%')
          ->orWhere('code', 'LIKE', '%'.$search.'%')
          ->orWhere('value', 'LIKE', '%'.$search.'%')
          ->orWhere('total', 'LIKE', '%'.$search.'%')
          ->orWhere('used', 'LIKE', '%'.$search.'%')
          ->orWhere('not_after', 'LIKE', '%'.$search.'%');
      } else {
        $search = '';
      }
      if (isset($type)) {
        switch ($type) {
          case 'enabled':
            $coupons = $coupons->where('enabled', 1);
            break;
          case 'disabled':
            $coupons = $coupons->where('enabled', 0);
            break;
        }
      } else {
        $type = 'all';
      }

      $coupons = $coupons->paginate(20);

      $filters = [
        'type' => $type,
        'search' => $search
      ];
      return view('admin.coupon.index', compact('coupons', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
      return view('admin.coupon.create');
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
      $coupon = CouponCode::find($id);
      // $categories = Category::whereNull('category_id')
        // ->with('childrenCategories')
        // ->get();
      // dd($coupon->productsEnabled, $categories, $coupon->categoriesEnabled, $coupon->productsDisabled, $coupon->categoriesDisabled);
      // foreach ($categories as $category) {
      //   echo '<li>' . $category->name . '</li>'.'<ul>';
      //   foreach ($category->childrenCategories as $childCategory) {
      //     $this->child($childCategory);
      //   }
      //   echo '</ul>';
      // }

      return view('admin.coupon.edit', compact('coupon'));
    }

    // private function child($child) {
    //   echo '<li>' . $child->name . '</li>';
    //   if ($child->categories) {
    //     echo '<ul>';
    //       foreach ($child->categories as $childCategory) {
    //         $this->child($childCategory);
    //       }
    //     echo '</ul>';
    //   }
    // }

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
    public function destroy($id)
    {
      $coupon = CouponCode::find($id);
      $coupon->enabled = 0;
      $coupon->save();
      return redirect()->route('admin.store.coupon.index');
    }

  public function collectionsDestroy(Request $request) {
    $coupons = CouponCode::find($request->id);
    foreach ($coupons as $coupon) {
      $coupon->enabled = 0;
      $coupon->save();
    }
    return ['status' => 'success'];
  }
}
