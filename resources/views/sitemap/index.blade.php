<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>{{ route('products.index') }}</loc>
    <lastmod></lastmod>
    <changefreq>monthly</changefreq>
    <priority>1</priority>
  </url>

  <url>
    <loc>{{ route('about') }}</loc>
    <lastmod></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.7</priority>
  </url>

  <url>
    <loc>{{ route('contact') }}</loc>
    <lastmod></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.7</priority>
  </url>

  <url>
    <loc>{{ route('policy') }}</loc>
    <lastmod></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.7</priority>
  </url>

  <url>
    <loc>{{ route('products.allsale') }}</loc>
    <lastmod></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.7</priority>
  </url>

  <url>
    <loc>{{ route('products.allactions') }}</loc>
    <lastmod></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.7</priority>
  </url>

  <url>
    <loc>{{ route('cart.index') }}</loc>
    <lastmod></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.7</priority>
  </url>

  <url>
    <loc>{{ route('orders.create') }}</loc>
    <lastmod></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.7</priority>
  </url>

  <url>
    <loc>{{ route('login') }}</loc>
    <lastmod></lastmod>
    <changefreq>monthly</changefreq>
    <priority>0.7</priority>
  </url>


  @foreach ($products as $pr)
    <url>
      <loc>{{ route('products.show', $pr->id) }}</loc>
      <lastmod>{{ $pr->updated_at->toAtomString() }}</lastmod>
      <changefreq>monthly</changefreq>
      <priority>0.9</priority>
    </url>
  @endforeach

  @foreach ($categories as $ct)
    <url>
      <loc>{{ route('products.all', ['category' => $ct->id]) }}</loc>
      <lastmod>{{ $ct->created_at ? $ct->created_at->toAtomString() : '' }}</lastmod>
      <changefreq>monthly</changefreq>
      <priority>0.8</priority>
    </url>
    @foreach ($brands as $br)
      <url>
        <loc>{{ route('products.all', ['category' => $ct->id, 'brand' => $br->id]) }}</loc>
        <lastmod>{{ $ct->created_at ? $ct->created_at->toAtomString() : '' }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
      </url>
    @endforeach
  @endforeach

  @foreach ($brands as $br)
    <url>
      <loc>{{ route('products.all', ['brand' => $br->id]) }}</loc>
      <lastmod>{{ $br->created_at ? $ct->created_at->toAtomString() : '' }}</lastmod>
      <changefreq>monthly</changefreq>
      <priority>0.8</priority>
    </url>
  @endforeach

  @foreach ($news as $ns)
    <url>
      <loc>{{ route('news.show', $ns->id) }}</loc>
      <lastmod>{{ $ns->updated_at->toAtomString() }}</lastmod>
      <changefreq>monthly</changefreq>
      <priority>0.7</priority>
    </url>
  @endforeach
  @foreach ($faqs as $fq)
    <url>
      <loc>{{ route('faqs.show', $fq->id) }}</loc>
      <lastmod>{{ $fq->updated_at->toAtomString() }}</lastmod>
      <changefreq>monthly</changefreq>
      <priority>0.7</priority>
    </url>
  @endforeach
</urlset>
