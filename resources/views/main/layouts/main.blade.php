<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Animal</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('dogs/img/favicon.png') }}">
    <!-- Place favicon.ico in the root directory -->

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('dogs/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dogs/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dogs/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('dogs/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dogs/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('dogs/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('dogs/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('dogs/css/gijgo.css') }}">
    <link rel="stylesheet" href="{{ asset('dogs/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('dogs/css/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('dogs/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('dogs/css/additional.css') }}">
    <!-- <link rel="stylesheet" href="css/responsive.css"> -->
</head>

<body>
<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
<![endif]-->

<header>
    <div class="header-area ">
        <div id="sticky-header" class="main-header-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-3 col-lg-3">
                        <div class="logo">
                            <a href="#">
                                <img src="{{ asset('dogs/img/logo.png') }}" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-9">
                        <div class="main-menu  d-none d-lg-block">
                            @if(isset($data['navigation']))
                                <nav>
                                    <ul id="navigation">
                                        @foreach($data['navigation'] as $item)
                                            <li><a  href="{{ route($item['routeName']) }}">{{ $item['title'] }}</a></li>
                                        @endforeach
                                    </ul>
                                </nav>
                            @endif
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
@yield('content')
<!-- footer_start  -->
<footer class="footer">
    <div class="footer_top">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-md-6 col-lg-3">
                    <div class="footer_widget">
                        <h3 class="footer_title">
                            Contact Us
                        </h3>
                        <ul class="address_line">
                            <li>+555 0000 565</li>
                            <li><a href="#">Demomail@gmail.Com</a></li>
                            <li>700, Green Lane, New York, USA</li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3  col-md-6 col-lg-3">
                    <div class="footer_widget">
                        <h3 class="footer_title">
                            Our Servces
                        </h3>
                        <ul class="links">
                            <li><a href="#">Pet Insurance</a></li>
                            <li><a href="#">Pet surgeries </a></li>
                            <li><a href="#">Pet Adoption</a></li>
                            <li><a href="#">Dog Insurance</a></li>
                            <li><a href="#">Dog Insurance</a></li>
                        </ul>
                    </div>
                </div>
                @if(isset($data['navigation']))
                    <div class="col-xl-3  col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <h3 class="footer_title">
                                Quick Link
                            </h3>
                            {{ Request::is('admin/' . $item['pathPrefix'] . '*') ? 'menu-is-opening menu-open' : '' }}
                            <ul class="links">
                                @foreach($data['navigation'] as $item)
                                    @if(Request::is($item['pathPrefix'] . '*'))
                                        <li>{{ $item['title'] }}</li>
                                    @else
                                        <li><a  href="{{ route($item['routeName']) }}">{{ $item['title'] }}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <div class="col-xl-3 col-md-6 col-lg-3 ">
                    <div class="footer_widget">
                        <div class="footer_logo">
                            <a href="#">
                                <img src="{{ asset('dogs/img/logo.png') }}" alt="">
                            </a>
                        </div>
                        <p class="address_text">239 E 5th St, New York
                            NY 10003, USA
                        </p>
                        <div class="socail_links">
                            <ul>
                                <li>
                                    <a href="#">
                                        <i class="ti-pinterest"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-google-plus"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-vk"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer_end  -->


<!-- JS here -->
<script src="{{ asset('dogs/js/vendor/modernizr-3.5.0.min.js') }}"></script>
<script src="{{ asset('dogs/js/vendor/jquery-1.12.4.min.js') }}"></script>
<script src="{{ asset('dogs/js/popper.min.js') }}"></script>
<script src="{{ asset('dogs/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('dogs/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('dogs/js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('dogs/js/ajax-form.js') }}"></script>
<script src="{{ asset('dogs/js/waypoints.min.js') }}"></script>
<script src="{{ asset('dogs/js/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('dogs/js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('dogs/js/scrollIt.js') }}"></script>
<script src="{{ asset('dogs/js/jquery.scrollUp.min.js') }}"></script>
<script src="{{ asset('dogs/js/wow.min.js') }}"></script>
<script src="{{ asset('dogs/js/nice-select.min.js') }}"></script>
<script src="{{ asset('dogs/js/jquery.slicknav.min.js') }}"></script>
<script src="{{ asset('dogs/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('dogs/js/plugins.js') }}"></script>
<script src="{{ asset('dogs/js/gijgo.min.js') }}"></script>

<!--contact js-->
<script src="{{ asset('dogs/js/contact.js') }}"></script>
<script src="{{ asset('dogs/js/jquery.ajaxchimp.min.js') }}"></script>
<script src="{{ asset('dogs/js/jquery.form.js') }}"></script>
<script src="{{ asset('dogs/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('dogs/js/mail-script.js') }}"></script>

<script src="{{ asset('dogs/js/main.js') }}"></script>
<script>
    $('#datepicker').datepicker({
        iconsLibrary: 'fontawesome',
        disableDaysOfWeek: [0, 0],
        //     icons: {
        //      rightIcon: '<span class="fa fa-caret-down"></span>'
        //  }
    });
    $('#datepicker2').datepicker({
        iconsLibrary: 'fontawesome',
        icons: {
            rightIcon: '<span class="fa fa-caret-down"></span>'
        }

    });
    var timepicker = $('#timepicker').timepicker({
        format: 'HH.MM'
    });
</script>
</body>

</html>
