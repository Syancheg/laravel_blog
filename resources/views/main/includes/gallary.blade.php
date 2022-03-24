<aside class="single_sidebar_widget instagram_feeds">
    <h4 class="widget_title">Новые фото</h4>
    <ul class="instagram_row flex-wrap">
        @foreach($gallary->images as $image)
            <li>
                <a href="#">
                    <img
                        class="img-fluid"
                        src="{{ Storage::url($image->image_path['min']) }}"
                        alt="{{ $gallary->name }}">
                </a>
            </li>
        @endforeach
    </ul>
</aside>
