<aside class="single_sidebar_widget tag_cloud_widget">
    <h4 class="widget_title">Облако тегов</h4>
    <ul class="list">
        @foreach($tags as $tag)
            <li>
                <a href="#">{{ $tag->title }}</a>
            </li>
        @endforeach
    </ul>
</aside>
