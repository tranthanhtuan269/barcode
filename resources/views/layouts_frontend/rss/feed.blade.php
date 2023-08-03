<?php
    date_default_timezone_set('asia/ho_chi_minh');
    $date = date('m/d/Y h:i:s a', time());
?>
<?=
'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss version="2.0">
    <channel xmlns="http://www.w3.org/2005/Atom">
        <title>Barcodelive.org RSS</title>
        <link>{{ url()->current() }}</link>
        <description>Barcodelive RSS</description>
        <language>vi</language>
        <lastBuildDate>{{ $date }}</lastBuildDate>
        <generator>Barcodelive</generator>
        @foreach($articles as $article)
            <item>
                <guid isPermaLink="true">{{ route('client.show-cat-article', ['slug' => $article->slug]) }}</guid>
                <link>{{ route('client.show-cat-article', ['slug' => $article->slug ]) }}</link>
                <title>{{ \App\Helpers\Helper::removeSpecialCharacter($article->title) }}</title>
                <description>{{ \App\Helpers\Helper::removeSpecialCharacter($article->description) }}</description>
                <pubDate>{{ $article->created_at->toRssString() }}</pubDate>
            </item>
        @endforeach
    </channel>
</rss>