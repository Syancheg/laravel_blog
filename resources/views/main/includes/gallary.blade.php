<aside class="single_sidebar_widget instagram_feeds">
    <h4 class="widget_title">Новые фото</h4>
    <ul class="instagram_row flex-wrap">
        @foreach($gallary[0]->images_src as $src)
            <li>
                <a href="#">
                    <img class="img-fluid" src="{{ Storage::url($src) }}" alt="{{ $gallary[0]->name }}">
                </a>
            </li>
        @endforeach
    </ul>
</aside>
