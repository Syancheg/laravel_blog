<aside class="single_sidebar_widget post_category_widget">
    <h4 class="widget_title">Категории</h4>
    <ul class="list cat-list">
        @foreach($categories as $category)
            <li>
                <a href="{{ route('public.content.category', [$category->slug]) }}" class="d-flex">
                    <p>{{ $category->title }}</p>
                    <p>{{ $category->count_posts }}</p>
                </a>
            </li>
        @endforeach
    </ul>
</aside>
