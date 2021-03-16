<?php

  namespace App\Http\Controllers\Admin;

  use App\Http\Controllers\Controller;
  use App\Models\Country;
  use App\Models\ExpressCompany;
  use App\Models\ExpressZone;
  use Exception;
  use Illuminate\Contracts\Foundation\Application;
  use Illuminate\Contracts\View\Factory;
  use Illuminate\Contracts\View\View;
  use Illuminate\Http\JsonResponse;
  use Illuminate\Http\RedirectResponse;
  use Illuminate\Http\Request;

  class ExpressZoneController extends Controller
  {
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(): void
    {
      //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
      return view('admin.express-zone.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
      if ($request->method_cost === 'step_and_cost') {
        $request->validate([
          'name' => 'required|unique:express_zones,name',
          'cost' => 'required|numeric|min:0',
          'step' => 'required|numeric|min:0',
          'cost_step' => 'required|numeric|min:0',
          'company_id' => 'required|exists:express_companies,id',
        ]);

        $zone = new ExpressZone();
        $zone = $zone->create($request->all());
      } else if ($request->method_cost === 'array_step') {
        $request->validate([
          'name' => 'required|unique:express_zones,name',
          'company_id' => 'required|exists:express_companies,id',
          'weight_to' => 'required',
          'weight_from' => 'required',
          'cost' => 'required'
        ]);
        $zone = new ExpressZone();
        $zone->name = $request->name;
        $zone->company()->associate($request->company_id);
        $step_cost_array = array();
        for ($i = 1, $iMax = count($request->cost); $i <= $iMax; $i++) {
          $step_cost_array[$i - 1] = (object)array();
          $step_cost_array[$i - 1]->cost = (double)$request->cost[$i];
          $step_cost_array[$i - 1]->weight_to = (double)$request->weight_to[$i];
          $step_cost_array[$i - 1]->weight_from = (double)$request->weight_from[$i];
        }
        $zone->step_cost_array = $step_cost_array;
        $zone->save();
      }

      return redirect()->route('admin.express-zone.edit', $zone->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show(int $id): void
    {
      //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit(int $id)
    {
      $zone = ExpressZone::find($id);
      return view('admin.express-zone.edit', compact('zone'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse|RedirectResponse|string[]
     */
    public function update(Request $request, int $id)
    {
      if (isset($request->cities_delete)) {
        $zone = ExpressZone::find($id);
        $zone->cities()->sync([]);
        return redirect()->route('admin.express-zone.edit', $zone->id);
      }

      if (isset($request->country_id)) {
        $zone = ExpressZone::find($id);
        $company = ExpressCompany::find($zone->company->id);
        $country = Country::find($request->country_id);
        $cities = [];
        foreach ($country->cities as $city) {
          if (!$company->cities->contains($city->id)) {
            array_push($cities, $city);
            $zone->cities()->attach($city->id, ['express_company_id' => $zone->company->id]);
          }
        }
        return response()->json(['success' => 'ok', 'cities' => $cities]);
      }

      if (isset($request->city_id)) {
        $zone = ExpressZone::find($id);
        $request->validate([
          'city_id' => 'required|unique:city_expresses,city_id,' . $request->city_id . ',id,express_company_id,' . $zone->company->id
        ]);

        $zone->cities()->attach($request->city_id, ['express_company_id' => $zone->company->id]);
        return ['success' => 'ok'];
      }

      if ($request->method_cost === 'step_and_cost') {
        $zone = ExpressZone::find($id);
        $request->validate([
          'name' => 'required|unique:express_zones,name,' . $id,
          'cost' => 'required|numeric|min:0',
          'step' => 'required|numeric|min:0',
          'cost_step' => 'required|numeric|min:0',
          'company' => 'required|exists:express_companies,id'
        ]);
        $zone->update($request->except('company'));
        $zone->company()->associate($request->company);
        $zone->save();
      } else if ($request->method_cost === 'array_step') {
        $zone = ExpressZone::find($id);
        $request->validate([
          'name' => 'required|unique:express_zones,name,' . $id,
          'company' => 'required|exists:express_companies,id',
          'weight_to' => 'required',
          'weight_from' => 'required',
          'cost' => 'required'
        ]);
        $zone->name = $request->name;
        $zone->company()->associate($request->company);
        $step_cost_array = array();
        for ($i = 1, $iMax = count($request->cost); $i <= $iMax; $i++) {
          $step_cost_array[$i - 1] = (object)array();
          $step_cost_array[$i - 1]->cost = (double)$request->cost[$i];
          $step_cost_array[$i - 1]->weight_to = (double)$request->weight_to[$i];
          $step_cost_array[$i - 1]->weight_from = (double)$request->weight_from[$i];
        }
        $zone->step_cost_array = $step_cost_array;
        $zone->save();
      }
      return redirect()->route('admin.express-zone.edit', $zone->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(int $id): RedirectResponse
    {
      $zone = ExpressZone::find($id);
      $zone->delete();
      return redirect()->route('admin.express.edit', $zone->company->id);
    }

    /**
     * @param Request $request
     * @param $id
     * @return string[]
     */
    public function destroyCity(Request $request, $id): array
    {
      if (isset($request->city_id)) {
        $zone = ExpressZone::find($id);
        $zone->cities()->detach($request->city_id);
        return ['success' => 'ok'];
      }
      return [];
    }
  }
