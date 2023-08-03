<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($barcodes as $value)
        <url>
            <loc>{{ route('seo-barcode', ['slug' => Illuminate\Support\Str::of($value->name)->slug('-') . '-' . $value->barcode]) }}</loc>
            <lastmod>{{ date('c', strtotime($value->updated_at)) }}</lastmod>
        </url>
    @endforeach
</urlset> 