
@foreach($posts as $post)
    <article class="blog_item">
        <div class="blog_item_img">
            <img
                class="card-img rounded-0 post-image image"
                @if($post->main_image)
                src="{{ Storage::url($post->mainImage->path_origin) }}"
                @else
                src="{{ Storage::url('public/noimg.png') }}"
                @endif
                alt="{{ $post->title }}"
            >
            <a href="#" class="blog_item_date">
                <h3>15</h3>
                <p>Jan</p>
            </a>
        </div>

        <div class="blog_details">
            <a class="d-inline-block" href="{{ route('public.content.post', [$post->category->slug, $post->slug]) }}">
                <h2>{{ $post->title }}</h2>
            </a>
            <p>That dominion stars lights dominion divide years for fourth have don't stars is that
                he earth it first without heaven in place seed it second morning saying.</p>
            <ul class="blog-info-link">
                <li><a href="#"><i class="fa fa-calendar"></i> {{ $post->format_date }}</a></li>
                <li><a href="#"><i class="fa fa-eye"></i> {{ $post->views }}</a></li>
            </ul>
        </div>
    </article>
@endforeach
@include('main.includes.pagination')
