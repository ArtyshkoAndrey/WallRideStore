<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
      $search = $request->search;
      $brands = Brand::query();
      if (isset($search)) {
        $brands = $brands->where('name', 'LIKE', '%' . $search . '%')
          ->orWhere('created_at', 'LIKE', '%'.$search.'%');
      } else {
        $search = '';
      }
      $filters = [
        'search' => $search,
      ];
      $brands = $brands->paginate(10);
      return view('admin.brand.index', compact('brands', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
      $categories = Category::select('*')->whereNotIn('id',function($query) {

        $query->select('child_category_id')->from('categories_categories');

      })->get();
      return view('admin.brand.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
      $ct = new Brand();
      $ct->name = $request->name;
      $ct->save();
      $ct->categories()->sync($request->categories);
      return redirect()->route('admin.production.brand.index');
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
      $brand = Brand::find($id);
      $categories = Category::select('*')->whereNotIn('id',function($query) {

        $query->select('child_category_id')->from('categories_categories');

      })->get();
      return view('admin.brand.edit', compact('brand', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
      $ct = Brand::find($id);
      $ct->name = $request->name;
      $ct->categories()->sync($request->categories);
      $ct->save();
      return redirect()->route('admin.production.brand.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
      Brand::destroy($id);
      return redirect()->route('admin.production.brand.index');
    }
}
