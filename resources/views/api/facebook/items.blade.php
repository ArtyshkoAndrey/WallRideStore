<?php echo '<?xml version="1.0"?>'; ?>
<rss xmlns:g="https://base.google.com/ns/1.0"
     version="2.0"
     xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
     xsi:schemaLocation="https://base.google.com/ns/1.0 ">
  <channel>
    <title>WallrideStore</title>
    <link>https://wallridestore.com</link>
    <description>Покупки и розничная торговля</description>
    @foreach ($products as $pr)
      <item>
        <g:id>{{ $pr->id }}</g:id>
        <g:title>{{ $pr->title }}</g:title>
        <g:description>{{ ucfirst(strtolower($pr->title)) }}</g:description>
        <g:link>{{ route('product.show', $pr->id) }}</g:link>
        <g:image_link>{{ $pr->thumbnail_jpg }}</g:image_link>
        <g:brand>{{ $pr->brand->name }}</g:brand>
        <g:condition>new</g:condition>
        <g:availability>in stock</g:availability>
        <g:price>{{ $pr->price }}</g:price>
      </item>
    @endforeach
  </channel>
</rss>
