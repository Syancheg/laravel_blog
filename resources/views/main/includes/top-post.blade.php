<aside class="single_sidebar_widget popular_post_widget">
    <h3 class="widget_title">Популярные посты</h3>
    @foreach($top_posts as $post)
        <div class="media post_item">
            <img
                class="image top-post-image"
                @if($post->main_image)
                src="{{ Storage::url($post->mainImage->path_origin) }}"
                @else
                src="{{ Storage::url('public/noimg.png') }}"
                @endif
                alt="{{ $post->title }}"
            >
            <div class="media-body">
                <a href="{{ route('public.content.post', [$post->category->slug, $post->slug]) }}">
                    <h3>{{ $post->title }}</h3>
                </a>
                <p>{{ $post->created_at }}</p>
            </div>
        </div>
    @endforeach
</aside>
