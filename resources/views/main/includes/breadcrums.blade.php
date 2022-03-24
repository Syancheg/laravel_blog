<!-- bradcam_area_start -->
<div class="bradcam_area breadcam_bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="bradcam_text text-center">
                    @foreach($breadcrumbs as $index => $breadcrumb)
                        @if($index !== count($breadcrumbs) - 1)
                            @if($breadcrumb['href'])
                                <a href="{{ $breadcrumb['href'] }}" title="{{ $breadcrumb['title'] }}">
                                    {{ $breadcrumb['title'] }}
                                </a>/
                            @else
                                {{ $breadcrumb['title'] }}/
                            @endif
                        @else
                                <h3>
                                    {{ $breadcrumb['title'] }}
                                </h3>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- bradcam_area_end -->
