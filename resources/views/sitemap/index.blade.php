<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{ route('sitemap.products') }}</loc>
        <lastmod>{{ $product->created_at->tz('UTC')->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{ route('sitemap.articles') }}</loc>
        <lastmod>{{ $article->created_at->tz('UTC')->toAtomString() }}</lastmod>
    </sitemap>
</sitemapindex>