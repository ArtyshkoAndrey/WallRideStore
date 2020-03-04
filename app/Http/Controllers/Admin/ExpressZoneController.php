<?php

namespace App\Http\Controllers\Admin;

use App\Models\ExpressZone;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ExpressZoneController extends Controller
{
  public function __construct()
  {
//    parent::__construct($cartService);
  }

  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
     * @param Request $request
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
   * @param $id
   * @return Factory|View
   */
    public function edit($id)
    {
      $zone = ExpressZone::find($id);
//      dd($zone->cities[0]->cityOriginal->name);
      return view('admin.express-zone.edit', compact('zone'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return array
     */
    public function update(Request $request, $id)
    {
      if (isset($request->city_id)) {
        $zone = ExpressZone::find($id);
        $request->validate([
          'city_id' => 'required|unique:city_expresses,city_id,'.$request->city_id.',id,express_company_id,'.$zone->company->id
        ]);

        $zone->cities()->attach($request->city_id, ['express_company_id' => $zone->company->id]);
        return ['success' => 'ok'];
      }
    }

  /**
   * Remove the specified resource from storage.
   *
   * @param Request $request
   * @param int $id
   * @return array
   */
    public function destroy(Request $request, $id)
    {
      if (isset($request->city_id)) {
        $zone = ExpressZone::find($id);
        $zone->cities()->detach($request->city_id);
        return $request;
      }
    }

  public function destroyCity(Request $request, $id)
  {
    if (isset($request->city_id)) {
      $zone = ExpressZone::find($id);
      $zone->cities()->detach($request->city_id);
      return ['success'=>'ok'];
    }
  }
}
