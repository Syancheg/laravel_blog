<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        @foreach($breadcrumbs as $breadcrumb)
            @if(isset($breadcrumb['routeName']))
                <li class="breadcrumb-item">
                    <a href="{{ route($breadcrumb['routeName']) }}">
                        {{ $breadcrumb['title'] }}
                    </a>
                </li>
            @else
                <li class="breadcrumb-item active">{{ $breadcrumb['title'] }}</li>
            @endif
        @endforeach
    </ol>
</div>
