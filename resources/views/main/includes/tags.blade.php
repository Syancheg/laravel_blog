<aside class="single_sidebar_widget tag_cloud_widget">
    <h4 class="widget_title">Облако тегов</h4>
    <ul class="list">
        @foreach($tags as $tag)
            <li>
                <a href="{{ route('public.content.tag', [$tag->id]) }}">{{ $tag->title }}</a>
            </li>
        @endforeach
    </ul>
</aside>
