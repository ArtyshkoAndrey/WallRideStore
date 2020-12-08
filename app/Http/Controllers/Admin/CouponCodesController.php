<?php

namespace App\Http\Controllers\Admin;

use App\Models\CouponCode;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Carbon\Carbon;

class CouponCodesController extends Controller
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
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
      $request->validate([
        'code' => 'required|unique:coupon_codes,code',
        'value' => 'required|numeric|min:0',
        'total' => 'required|numeric|min:0'
      ]);
      $coupon = new CouponCode();
      $coupon->name = $request->code;
      $coupon->code = $request->code;
      $coupon->type = $request->type;
      $coupon->value = $request->value;
      $coupon->total = $request->total;
      $coupon->min_amount = $request->min_amount;
      $coupon->max_amount  =$request->max_amount;
      $coupon->disabled_other_coupons = false;
      $coupon->disabled_other_sales = false;
      if (isset($request->disabled_other_coupons))
        $coupon->disabled_other_coupons = true;
      if (isset($request->disabled_other_sales))
        $coupon->disabled_other_sales = true;
      $coupon->not_after = Carbon::parse($request->not_after);
      // $coupon->categoriesDisabled()->detach();
      $coupon->save();
      $coupon->productsEnabled()->sync($request->products);
      $coupon->productsDisabled()->sync($request->disabled_products);
      $coupon->brandsEnabled()->sync($request->brands);
      $coupon->brandsDisabled()->sync($request->disabled_brands);
      $coupon->categoriesEnabled()->sync($request->categories);
      $coupon->categoriesDisabled()->sync($request->disabled_categories);

      return redirect()->route('admin.store.coupon.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Factory|View
     */
    public function edit (int $id)
    {
      $coupon = CouponCode::find($id);
      return view('admin.coupon.edit', compact('coupon'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int $id
     * @return RedirectResponse
     */
    public function update (Request $request, int $id): RedirectResponse
    {
      $request->validate([
        'code' => 'required|unique:coupon_codes,code,'.$id,
        'value' => 'required|numeric|min:0',
        'total' => 'required|numeric|min:0'
      ]);
      $coupon = CouponCode::find($id);
      $coupon->name = $request->code;
      $coupon->code = $request->code;
      $coupon->type = $request->type;
      $coupon->value = $request->value;
      $coupon->total = $request->total;
      $coupon->min_amount = $request->min_amount;
      $coupon->max_amount  =$request->max_amount;
      $coupon->disabled_other_coupons = false;
      $coupon->disabled_other_sales = false;
      if (isset($request->disabled_other_coupons))
        $coupon->disabled_other_coupons = true;
      if (isset($request->disabled_other_sales))
        $coupon->disabled_other_sales = true;
      $coupon->not_after = Carbon::parse($request->not_after);
      // $coupon->categoriesDisabled()->detach();
      $coupon->save();
      $coupon->productsEnabled()->sync($request->products);
      $coupon->productsDisabled()->sync($request->disabled_products);
      $coupon->brandsEnabled()->sync($request->brands);
      $coupon->brandsDisabled()->sync($request->disabled_brands);
      $coupon->categoriesEnabled()->sync($request->categories);
      $coupon->categoriesDisabled()->sync($request->disabled_categories);
      // dd($request->disabled_category);
      return redirect()->route('admin.store.coupon.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return RedirectResponse
     */
    public function destroy (int $id): RedirectResponse
    {
      $coupon = CouponCode::find($id);
      $coupon->enabled = 0;
      $coupon->save();
      return redirect()->route('admin.store.coupon.index');
    }

  public function collectionsDestroy (Request $request): array
  {
    $coupons = CouponCode::find($request->id);
    foreach ($coupons as $coupon) {
      $coupon->enabled = 0;
      $coupon->save();
    }
    return ['status' => 'success'];
  }
}
