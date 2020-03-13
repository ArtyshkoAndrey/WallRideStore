<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Skus;

class SkusController extends Controller
{
  public function __construct() {

  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $type = $request->type;
    $search = $request->search;
    $skus = Skus::query();
    if (isset($search)) {
      $skus = $skus->where('title', 'LIKE', '%' . $search . '%')
        ->orWhere('created_at', 'LIKE', '%'.$search.'%');
    } else {
      $search = '';
    }
    if (isset($type)) {
      switch ($type) {
        case 'published':
          $skus = $skus;
          break;
        case 'all':
          $skus = $skus;
          break;
      }
    } else {
      $type = 'all';
    }
    $filters = [
      'search' => $search,
      'type' => $type
    ];
    $skus = $skus->paginate(10);
    return view('admin.skus.index', compact('skus', 'filters'));
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
    
  }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $sku = Skus::find($id);
      return view('admin.skus.edit', compact('sku'));
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
