<?xml version="1.0" encoding="UTF-8" ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ url('/')}}</loc>
        <lastmod>2019-11-11T14:00:00+00:00</lastmod>
    </url>
    <url>
        <loc>{{ url('/').'/add-barcode' }}</loc>
        <lastmod>2019-11-11T14:00:00+00:00</lastmod>
    </url>
    <url>
        <loc>{{ url('/').'/faqs' }}</loc>
        <lastmod>2019-11-11T14:00:00+00:00</lastmod>
    </url>
    <url>
        <loc>{{ url('/').'/terms-and-conditions' }}</loc>
        <lastmod>2019-11-11T14:00:00+00:00</lastmod>
    </url>
    <url>
        <loc>{{ url('/').'/about' }}</loc>
        <lastmod>2019-11-11T14:00:00+00:00</lastmod>
    </url>
    <url>
        <loc>{{ url('/').'/app' }}</loc>
        <lastmod>2019-11-11T14:00:00+00:00</lastmod>
    </url>
    @foreach ($cates as $cate)
        <url>
            <loc>{{ url('/') }}/{{ $cate->slug }}</loc>
            <lastmod>{{ $cate->updated_at->toAtomString() }}</lastmod>
        </url>
    @endforeach
    @foreach ($articles as $article)
        <url>
            <loc>{{ url('/') }}/{{ $article->slug }}</loc>
            <lastmod>{{ $article->updated_at->toAtomString() }}</lastmod>
        </url>
    @endforeach  
</urlset> 