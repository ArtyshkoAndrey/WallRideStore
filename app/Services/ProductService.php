<?php


  namespace App\Services;


  use App\Models\Brand;
  use App\Models\Category;
  use App\Models\Photo;
  use App\Models\Product;
  use App\Models\ProductSkus;
  use App\Models\Skus;
  use Error;
  use Illuminate\Database\Eloquent\Model;
  use Intervention\Image\ImageManagerStatic as Image;

  class ProductService
  {

    protected static array $imageType = [
      'jpg',
      'webp'
    ];

    public function create(array $product): void
    {

      $p = new Product();

      $p->{'title:ru'} = $product['title'];
      $p->{'title:en'} = $product['title'];

      $p->{'description:ru'} = $product['description'];
      $p->{'description:en'} = $product['description'];

      $p->on_sale = $product['on_sale'];
      $p->on_new = $product['on_new'];
      $p->on_top = $product['on_top'];
      $p->price = (int)$product['price'];
      $p->price_sale = $product['price_sale'] !== null ? (int)$product['price_sale'] : null;
      $p->weight = $product['weight'];
      $meta = (object) [
        'title' => $product['title'],
        'description' => $product['title']
      ];
      $p->meta = $meta;
      $p->sold_count = $product['sold_count'];

      if(count($product['categories']) > 0) {
        $category = Category::whereTranslationLike('name', '%' . $product['categories'][0]['name'] . '%', 'ru')->first();
        $p->category()->associate($category);
      }

      if(count($product['brands']) > 0) {
        $brands = Brand::where('name', 'like',  '%' . $product['brands'][0]['name'] . '%')->first();
        $p->brand()->associate($brands);
      }

      $p->save();

      foreach ($product['skus'] as $skus) {
        if($skus['skus']) {
          $s = Skus::where('title', $skus['skus']['title'])->first();
          if ($s && (int)$skus['stock'] > 0) {
            $ps = new ProductSkus();
//            dd($skus['stock']);
            $ps->stock = (int)$skus['stock'];
            $ps->skus()->associate($s);
            $ps->product()->associate($p);
            try {
              $ps->save();
            } catch (Error $e) {
              dd($skus, $s, $p);
            }

          } else {
            continue;
          }
        } else if ((int)$skus['stock'] > 0) {
          $s = Skus::where('title', 'Без размера')->first();
          $ps = new ProductSkus();
          $ps->stock = $skus['stock'];
          $ps->skus()->associate($s);
          $ps->product()->associate($p);
          $ps->save();
        }
      }

      foreach ($product['photos'] as $photo) {
        $n = str_replace(" ", "%20", $photo['name']);
        $image = Image::make('https://wallridestore.com/public/storage/products/' . $n);

        $nameNonType = explode('.jpg', $photo['name'])[0];

        $destinationPath = public_path(Product::PHOTO_PATH);
        foreach (self::$imageType as $type) {
          $name = $nameNonType . '.' . $type;
          $img = $image->encode($type, 80);
          $img->fit(1200, 1200, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
          });
          $img->save($destinationPath . '/' . $name);
        }

        $destinationPath = public_path(Product::THUMBNAIL_PATH);
        foreach (self::$imageType as $type) {
          $name = $nameNonType . '.' . $type;
          $img = $image->encode($type, 30);
          $img->fit(500, 500, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
          });
          $img->save($destinationPath . '/' . $name);
        }

//        $name = PhotoService::create($request->file('file'), Product::THUMBNAIL_PATH, true, 30, false, 500);
//        PhotoService::create($request->file('file'), Product::PHOTO_PATH, true, 80, false, 1200);
        $photo = new Photo(['name' => $nameNonType]);
        $photo->product()->associate($p);
        $photo->save();
      }

    }

  }
