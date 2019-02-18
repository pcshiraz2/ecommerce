<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($products as $product)
        <url>
            <loc>{{ route('product.view.slug',[$product->id, $product->slug]) }}</loc>
            <lastmod>{{ $product->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>1.0</priority>
        </url>
    @endforeach
</urlset>