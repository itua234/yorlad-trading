<!doctype html>
<html class="no-js" lang="en">
<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <meta name="viewport" content="">
    <meta name="theme-color" content="#3e4684">
    <title>Vado Global - Digital Investment Platform</title>
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/favicon.png')}}" />
    <?php date_default_timezone_set("Africa/Lagos"); ?>

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        
    <!--====== Animate CSS ======-->
    <link rel="stylesheet" href="{{asset('home_assets/css/animate.css')}}">
        
    <!--====== Slick CSS ======-->
    <link rel="stylesheet" href="{{asset('home_assets/css/slick.css')}}">
        
    <!--====== Line Icons CSS ======-->
    <link rel="stylesheet" href="{{asset('home_assets/css/LineIcons.css')}}">
        
    <!--====== Bootstrap CSS ======-->
    <link rel="stylesheet" href="{{asset('home_assets/css/bootstrap.min.css')}}">

    <link href="{{asset('assets/css/dashboard.css')}}" rel="stylesheet" type="text/css">
    
    <!--====== Default CSS ======-->
    <link rel="stylesheet" href="{{asset('home_assets/css/default.css')}}">
    
    <!--====== Style CSS ======-->
    <link rel="stylesheet" href="{{asset('home_assets/css/style.css')}}">
    
</head>

<body>
    <!--[if IE]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->

    <!--====== PRELOADER PART START ======-->

    <div class="preloader">
        <div class="loader">
            <div class="ytp-spinner">
                <div class="ytp-spinner-container">
                    <div class="ytp-spinner-rotator">
                        <div class="ytp-spinner-left">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                        <div class="ytp-spinner-right">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--====== PRELOADER PART ENDS ======-->

    <!--====== HEADER PART START ======-->

    <section class="header_area">
        <div class="header_navbar">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand" href="#">
                                <img src="home_assets/images/vado_logo.png" width="300px" alt="Logo">
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul id="nav" class="navbar-nav ml-auto">
                                    <li class="nav-item active">
                                        <a class="page-scroll" href="#home">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#about">About</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="{{url('/login')}}">Login</a>
                                    </li>
                                </ul>
                            </div> <!-- navbar collapse -->
                        </nav> <!-- navbar -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- header navbar -->

        <div id="home" class="header_slider slider-active">
            <div class="single_slider bg_cover d-flex align-items-center" style="background-image: url(home_assets/images/slider-1.jpg)">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="slider_content">
                                <h2 class="slider_title">A Digital platform for Agribusiness</h2>
                                <p class="wow fadeInUp">A global digital platform that gives everyone the opportunity to engage in Agribusiness anytime and on the go, by funding farms and trading of agricultural commodities.</p>
                                <a href="{{url('/products')}}" rel="nofollow" class="main-btn">Our Products</a>
                            </div> <!-- slider content -->
                        </div>
                    </div> <!-- row -->
                </div> <!-- container -->
            </div> <!-- single slider -->
        </div> <!-- header slider -->
    </section>

    <!--====== HEADER PART ENDS ======-->

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section_title text-center pb-30 mt-3">
                    <h4 class="title">Our Products</h4>
                    <span class="line">
                        <span class="box"></span>
                    </span>
                </div> <!-- section title -->
            </div>
        </div> <!-- row -->
        <div class="row justify-content-center">
            <div class="col pos-relative">
                <div class="mt-2">
                    <div class="container-fluid mt-3">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                @foreach ($categories as $category)
                                    <button class="nav-link <?php echo ($category->id == 1) ? 'active' : ''; ?>" 
                                    id="{{$category->name}}-tab" data-bs-toggle="tab" 
                                    data-bs-target="#{{$category->name}}" type="button" role="tab" 
                                    aria-controls="{{$category->name}}" aria-selected="true">{{$category->name}}</button>
                                @endforeach
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            @foreach ($categories as $category)
                                <div class="tab-pane fade show <?php echo ($category->id == 1) ? 'active' : ''; ?>" 
                                id="{{$category->name}}" 
                                role="tabpanel" aria-labelledby="{{$category->name}}-tab">
                                    <div class="row product-container">
                                        @foreach ($category->products as $product)
                                            <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12">
                                                <div class="product-content">
                                                    <div class="card" style="border:none;" href="/product/{{$product->uuid}}">
                                                        <img class="card-img-top" src="{{asset('assets/images/products/' . $product->photo) }}" alt="Card image cap">
                                                        <div class="card-body pb-2">
                                                            <div>{{$product->name}}</div>
                                                            <!--<div class="d-flex justify-content-between p-0 m-0">
                                                                <span>Daily Income</span>
                                                                <span>{{$product->currency->type." ".number_format($product->daily_income)}}</span>
                                                            </div>-->
                                                            <div class="d-flex justify-content-between p-0 m-0">
                                                                <span>Validity Period</span>
                                                                <span>{{$product->validity}} days</span>
                                                            </div>
                                                            <!--<div class="d-flex justify-content-between p-0 m-0">
                                                                <span>Total Revenue</span>
                                                                <span>{{$product->currency->type." ".number_format($product->returns)}}</span>
                                                            </div>-->
                                                            <div class="text-center">
                                                                <span style="
                                                                text-decoration:line-through;text-decoration-color:red">
                                                                    @if (!$product->old_price == 0)
                                                                        {{$product->currency->type." ".number_format($product->old_price)}}
                                                                    @endif
                                                                </span>
                                                                
                                                                <a href="/product/{{$product->uuid}}" class="btn btn-primary"
                                                                style="width:100%;font-size:14px;">
                                                                    {{$product->currency->type." ".number_format($product->price)}}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
        
    <!--====== ABOUT PART START ======-->

    <section id="about" class="about_area pt-120 pb-130">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section_title text-center pb-10">
                        <h4 class="title">Our Story</h4>
                        <span class="line">
                            <span class="box"></span>
                        </span>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about_image mt-50 wow fadeInRightBig" data-wow-duration="1.3s" data-wow-delay="0.5s">
                        <img src="home_assets/images/about.jpg" alt="about">
                    </div> <!-- about image -->
                </div>
                <div class="col-lg-6">
                    <div class="about_content mt-45 wow fadeInLeftBig" data-wow-duration="1.3s" data-wow-delay="0.5s">
                        <h4 class="about_title">About Coffee Shop</h4>
                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr. <br> <br> Sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.</p>
                        <ul class="social">
                            <li><a href="#"><i class="lni lni-facebook-filled"></i></a></li>
                            <li><a href="#"><i class="lni lni-twitter-original"></i></a></li>
                            <li><a href="#"><i class="lni lni-instagram-original"></i></a></li>
                            <li><a href="#"><i class="lni lni-linkedin-original"></i></a></li>
                        </ul>
                    </div> <!-- row -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== ABOUT PART ENDS ======-->
    
    <!--====== COUNTER PART START ======-->

    <section id="counter" class="counter_area pt-50 pb-95 bg_cover text-center" style="background-image: url(home_assets/images/counter_bg.jpg)">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <div class="single_counter mt-30 wow fadeIn" data-wow-duration="1.3s" data-wow-delay="0.2s">
                        <span style="font-size:18px;">Healthy Returns</span>
                        <p style="font-size:14px;">The most profitable farming and commodity trading experience you can think of. Yes, we Know!</p>
                    </div> <!-- single counter -->
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="single_counter mt-30 wow fadeIn" data-wow-duration="1.3s" data-wow-delay="0.5s">
                        <span style="font-size:18px;">Short Cycles</span>
                        <p style="font-size:14px;">Fast turnaround times ranging from 3 up to about 6 weeks depending on farm or commodity trade type</p>
                    </div> <!-- single counter -->
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="single_counter mt-30 wow fadeIn" data-wow-duration="1.3s" data-wow-delay="0.8s">
                        <span style="font-size:18px;">Low Capital</span>
                        <p style="font-size:14px;">Low minimum investment required per unit, you can start a farm or execute a trade with as low as N5,000</p>
                    </div> <!-- single counter -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== COUNTER PART ENDS ======-->
    
    <!--====== CUSTOMER PART START ======-->

    <section id="customer" class="customer_area pt-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section_title text-center pb-30">
                        <h4 class="title">Customers Feedback</h4>
                        <span class="line">
                            <span class="box"></span>
                        </span>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="row customer_active">
                <div class="col-lg-6">
                    <div class="single_customer d-sm-flex align-items-center mt-30">
                        <div class="customer_image">
                            <img src="home_assets/images/customer-1.jpg" alt="customer">
                        </div>
                        <div class="customer_content media-body">
                            <div class="customer_content_wrapper media-body">
                                <h5 class="author_name">Justyna Helen</h5>
                                <span class="sub_title">Coffee Lover</span>
                                <p>Lorem ipsum dolor sit amdi scing elitr, sed diam nonumy eirmo tem invidunt ut labore etdolo magna aliquyam erat, sed diam voluptua. At vero eos et accusam.</p>
                                <ul class="star">
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><i class="lni lni-star-filled"></i></li>
                                </ul>
                            </div>
                        </div>
                    </div> <!-- single customer -->
                </div>
                <div class="col-lg-6">
                    <div class="single_customer d-sm-flex align-items-center mt-30">
                        <div class="customer_image">
                            <img src="home_assets/images/customer-2.jpg" alt="customer">
                        </div>
                        <div class="customer_content media-body">
                            <div class="customer_content_wrapper media-body">
                                <h5 class="author_name">Fajar Siddiq</h5>
                                <span class="sub_title">Coffee Enthusiast</span>
                                <p>Lorem ipsum dolor sit amdi scing elitr, sed diam nonumy eirmo tem invidunt ut labore etdolo magna aliquyam erat, sed diam voluptua. At vero eos et accusam.</p>
                                <ul class="star">
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><i class="lni lni-star-filled"></i></li>
                                </ul>
                            </div>
                        </div>
                    </div> <!-- single customer -->
                </div>
                <div class="col-lg-6">
                    <div class="single_customer d-sm-flex align-items-center mt-30">
                        <div class="customer_image">
                            <img src="home_assets/images/customer-3.jpg" alt="customer">
                        </div>
                        <div class="customer_content media-body">
                            <div class="customer_content_wrapper media-body">
                                <h5 class="author_name">Rob Hope</h5>
                                <span class="sub_title">Enthusiasts</span>
                                <p>Lorem ipsum dolor sit amdi scing elitr, sed diam nonumy eirmo tem invidunt ut labore etdolo magna aliquyam erat, sed diam voluptua. At vero eos et accusam.</p>
                                <ul class="star">
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><i class="lni lni-star-filled"></i></li>
                                    <li><i class="lni lni-star-filled"></i></li>
                                </ul>
                            </div>
                        </div>
                    </div> <!-- single customer -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== CUSTOMER PART ENDS ======-->
    
    <!--====== GALLERY PART START ======-->

    <section id="gallery" class="gallery_area pt-120 pb-130">


    </section>

    <!--====== GALLERY PART ENDS ======-->
    
    <!--====== COFFEE MENU PART START ======-->

    <section id="menu" class="coffee_menu pt-120 pb-130 bg_cover" style="background-image: url(home_assets/images/coffee_menu_bg.jpg)">

                    <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <h2>You Invest!, We Farm Process& Sell!, You Profit!</h2>
                                <p class="wow fadeInUp">Vado Agrotrading investment is a simple and secure collaborative platform that enables you engage in profitable agribusiness opportunities from the comfort of your home. You can invest in Farms, trade in commodities and count your profits in no time.</p>
                                </br>
                                <a href="{{url('/register')}}" rel="nofollow" class="main-btn">Purchase Now</a>
                            </div> <!-- slider content -->
                        </div>
                    </div> <!-- row -->
                </div> <!-- container -->

    </section>

    <!--====== COFFEE MENU PART ENDS ======-->
    
    <!--====== upcoming PART START ======-->

    <section id="upcoming" class="upcoming_area pt-120">
    </section>

    <!--====== upcoming PART ENDS ======-->
    
    <!--====== CONTACT PART START ======-->

    <section id="contact" class="contact_area">
        <div class="contact_form pt-120 pb-130">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="section_title text-center pb-30">
                            <h4 class="title">Get In Touch</h4>
                            <span class="line">
                                <span class="box"></span>
                            </span>
                        </div> <!-- section title -->
                    </div>
                </div> <!-- row -->
                <form id="contact-form" action="mailto:support@vadoglobal.com" method="post">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="single_form mt-30">
                                <input name="name" type="text" placeholder="Name">
                            </div> <!-- single form -->
                        </div>
                        <div class="col-lg-6">
                            <div class="single_form mt-30">
                                <input name="email" type="email" placeholder="Email">
                            </div> <!-- single form -->
                        </div>
                        <div class="col-lg-12">
                            <div class="single_form mt-30">
                                <input name="subject" type="text" placeholder="Subject">
                            </div> <!-- single form -->
                        </div>
                        <div class="col-lg-12">
                            <div class="single_form mt-30">
                                <textarea name="message" placeholder="Message"></textarea>
                            </div> <!-- single form -->
                        </div>
                        <p class="form-message"></p>
                        <div class="col-lg-12">
                            <div class="single_form text-center mt-30">
                                <button class="main-btn">SUBMIT</button>
                            </div> <!-- single form -->
                        </div>
                    </div> <!-- row -->
                </form>
            </div> <!-- container -->
        </div> <!-- contact form -->
        <div class="contact_map">
            <div class="gmap_canvas">                            
                <iframe id="gmap_canvas" src="https://maps.google.com/maps?q=Mission%20District%2C%20San%20Francisco%2C%20CA%2C%20USA&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
            </div>
        </div> <!-- contact map -->
    </section>

    <!--====== CONTACT PART ENDS ======-->
    
    <!--====== FOOTER PART START ======-->

    <section id="footer" class="footer_area">
        <div class="footer_subscribe pt-80">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="subscribe_title mt-45">
                            <h4 class="title">Subscribe Our Newsletter</h4>
                            <p>To recieve monthly updates</p>
                        </div> <!-- subscribe title -->
                    </div>
                    <div class="col-lg-6">
                        <div class="subscribe_form mt-50">
                            <form action="#">
                                <input type="email" placeholder="Enter Your Email">
                                <button><i class="lni lni-envelope"></i></button>
                            </form>
                        </div> <!-- subscribe title -->
                    </div>
                </div> <!-- row -->
            </div> <!-- contact form -->
        </div> <!-- footer subscribe  -->
        
        <div class="footer_widget pt-80 pb-130">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 order-md-1 order-lg-1">
                        <div class="footer_about mt-45">
                            <h4 class="footer_title">About Us</h4>
                            <p>Vado Trading is one of the leading digital Agro-investment platforms, our mission is to foster collaborative development in the agricultural sector</p>
                            <ul class="social">
                                <li><a href="#"><i class="lni lni-facebook-filled"></i></a></li>
                                <li><a href="#"><i class="lni lni-twitter-original"></i></a></li>
                                <li><a href="#"><i class="lni lni-instagram-original"></i></a></li>
                                <li><a href="#"><i class="lni lni-linkedin-original"></i></a></li>
                            </ul>
                        </div> <!-- footer about -->
                    </div>
                    <!--<div class="col-lg-4 order-md-3 order-lg-2">
                        <div class="footer_link_wrapper d-flex flex-wrap">
                            <div class="footer_link mt-45">
                                <h4 class="footer_title">Opening Hours</h4>
                                <ul>
                                    <li>Mon-Fri: 08.00 A.M - 10.00 P.M</li>
                                    <li>Saturday: 08.00 A.M - 02.00 P.M</li>
                                    <li>Sunday: Closed</li>
                                    <li>Half-Holidays: 08.00 A.M - 02.00 P.M</li>
                                    <li>Twe: 08.00 A.M - 02.00 P.M</li>
                                </ul>
                            </div>   
                    </div>-->
                    <div class="col-lg-4 col-md-4 order-md-2 order-lg-3">
                        <div class="footer_instagram mt-45">
                            <h4 class="footer_title" style="margin-bottom:10px;">Contact</h4>
                            <div>
                                <a style="color:white" href="https://wa.me/+18058059883?text=Hello my name is ......">
                                    <span><ion-icon name="logo-whatsapp"></ion-icon></span>
                                    <span>+18058059883</span>
                                </a>
                            </div>
                            <div>
                                <a style="color:white" href="mailto:support@vadoglobal.com?subject=Vado Global Support">
                                    <span><ion-icon name="mail-outline"></ion-icon></span>
                                    <span>support@vadoglobal.com</span></a>
                                </a>
                            </div>
                        </div> <!-- footer instagram -->
                    </div>
                </div> <!-- row -->
            </div> <!-- contact form -->
        </div> <!-- footer Widget -->
        
        <div class="footer_copyright">
            <div class="container">
                <div class="copyright text-center">
                    <p>COPYRIGHT © 2023 VADO GLOBAL TRADING. ALL RIGHTS RESERVED</p>
                </div> <!-- copyright -->
            </div> <!-- contact form -->
        </div> <!-- footer copyright -->
        
        <div class="footer_shape">
            <img src="home_assets/images/footer_shape.png" alt="footer shape">
        </div> <!-- footer shape -->
    </section>

    <!--====== FOOTER PART ENDS ======-->
    
    <!--====== BACK TOP TOP PART START ======-->

    <a href="#" class="back-to-top"><i class="lni lni-chevron-up"></i></a>

    <!--====== BACK TOP TOP PART ENDS ======-->
    
    <!--====== PART START ======-->

<!--
    <section class="">
        <div class="container">
            <div class="row">
                <div class="col-lg-">
                    
                </div>
            </div>
        </div>
    </section>
-->

    <!--====== PART ENDS ======-->




    <!--====== Jquery js ======-->
    <script src="{{asset('home_assets/js/vendor/jquery-3.5.1.min.js')}}"></script>
    <script src="{{asset('home_assets/js/vendor/modernizr-3.7.1.min.js')}}"></script>
    
    <!--====== Bootstrap js ======-->
    <script src="{{asset('home_assets/js/popper.min.js')}}"></script>
    <script src="{{asset('home_assets/js/bootstrap.min.js')}}"></script>
    
    <!--====== Slick js ======-->
    <script src="{{asset('home_assets/js/slick.min.js')}}"></script>
    
    
    <!--====== Scrolling Nav js ======-->
    <script src="{{asset('home_assets/js/jquery.easing.min.js')}}"></script>
    <script src="{{asset('home_assets/js/scrolling-nav.js')}}"></script>
    
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!--====== WOW js ======-->
    <script src="{{asset('home_assets/js/wow.min.js')}}"></script>
    
    <!--====== Main js ======-->
    <script src="{{asset('home_assets/js/main.js')}}"></script>
    
</body>

</html>