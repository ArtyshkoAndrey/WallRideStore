<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\FAQ;
use App\Models\News;

use Illuminate\Http\Request;

class SitemapController extends Controller
{
  public function index()
  {
    $products = Product::all();
    $categories = Category::all();
    $brands = Brand::all();
    $faqs = FAQ::all();
    $news = News::all();

    return response()->view('sitemap.index', compact('products', 'categories', 'brands', 'faqs', 'news'))->header('Content-Type', 'text/xml');
  }
}
