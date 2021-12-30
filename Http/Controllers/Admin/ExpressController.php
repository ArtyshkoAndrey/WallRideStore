<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpressCompany;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ExpressController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return Application|Factory|View
   */
  public function index()
  {
    $expresses = ExpressCompany::all();
    return view('admin.express.index', compact('expresses'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Application|Factory|View
   */
  public function create()
  {
    return view('admin.express.create');
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
      'name' => 'required|unique:express_companies,name',
      'description' => 'required',
      'min_cost' => 'required|min:0'
    ]);

    $express = new ExpressCompany($request->all());
    $express->save();

    return redirect()->route('admin.express.edit', $express->id)->with('success', ['Компания успешно создана']);
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
   * @throws BindingResolutionException
   */
  public function edit(int $id)
  {
    $express = ExpressCompany::find($id);
    return view('admin.express.edit', compact('express'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param int $id
   * @return RedirectResponse
   */
  public function update(Request $request, int $id): RedirectResponse
  {
    $request->validate([
      'name' => 'required|unique:express_companies,name,' . $id,
      'description' => 'required',
      'min_cost' => 'required|min:0'
    ]);

    $express = ExpressCompany::find($id);
    $express->update($request->all());
    return redirect()->route('admin.express.edit', $express->id)->with('success', ['Компания успешно изменена']);
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
    $company = ExpressCompany::find($id);
    $company->delete();
    return redirect()->route('admin.express.index')->with('success', ['Компания успешно удалена']);
  }
}
