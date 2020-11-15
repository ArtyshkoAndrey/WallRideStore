<?php echo '<?xml version="1.0"?>'; ?>
<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
  <channel>
    <title>WallrideStore</title>
    <link>https://wallridestore.com</link>
    <description>Покупки и розничная торговля</description>
    @foreach ($products as $pr)
      <item>
        <g:id>{{ $pr->id }}</g:id>
        <g:title>{{ $pr->title }}</g:title>
        <g:description>{{ ucfirst(strtolower($pr->title)) }}</g:description>
        <g:link>{{ route('products.show', $pr->id) }}</g:link>
        <g:image_link>{{ asset('storage/products/' . $pr->photos[0]->name) }}</g:image_link>
        @if (count($pr->brands) > 0)
          <g:brand>{{ $pr->brands[0]->name }}</g:brand>
        @endif
        <g:condition>new</g:condition>
        <g:availability>in stock</g:availability>
        <g:price>{{ $pr->price }}</g:price>
{{--        <g:shipping>--}}
{{--          <g:country>UK</g:country>--}}
{{--          <g:service>Standard</g:service>--}}
{{--          <g:price>4.95 GBP</g:price>--}}
{{--        </g:shipping>--}}
{{--        <g:google_product_category>Animals &gt; Pet Supplies</g:google_product_category>--}}
{{--        <g:custom_label_0>Made in Waterford, IE</g:custom_label_0>--}}
      </item>
    @endforeach
  </channel>
</rss>
