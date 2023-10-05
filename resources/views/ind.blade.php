<!DOCTYPE html>
<html>
    <head>
        <!-- Basic Page Info -->
        <meta charset="utf-8">
	    <meta name="viewport" content="">
        <meta name="theme-color" content="#3e4684">
        <title>Vado Global - Trading Platform</title>
        <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/favicon.png')}}" />
        <?php date_default_timezone_set("Africa/Lagos"); ?>

        <!-- Mobile Specific Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <!-- CSS -->
        <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/css/dashboard.css')}}" rel="stylesheet" type="text/css">
    </head>
    <style>
        .carousel-control-prev{
            border:2px solid red;
            background-color: none;
        }
    </style>
    <body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-xl-6 col-md-8 col-sm-11 pos-relative">
                <div class="body-container mt-2">
                    <div class="d-flex justify-content-start align-items-center mb-2">
                        <img src="{{asset('assets/images/vado_logo.png')}}" style="width:200px" />
                    </div>

                    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active" style="height:250px;">
                                <img src="{{asset('assets/images/products/product1.jpeg')}}" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item" style="height:250px;">
                                <img src="{{asset('assets/images/products/product5.jpeg')}}" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item" style="height:250px;">
                                <img src="{{asset('assets/images/products/product4.jpeg')}}" class="d-block w-100" alt="...">
                            </div>
                        </div>
                    </div>

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
                                            <div class="col-6">
                                                <div class="product-content">
                                                    <div class="card" style="border:none;" href="/product/{{$product->uuid}}">
                                                        <img class="card-img-top" src="{{asset('assets/images/products/' . $product->photo) }}" alt="Card image cap">
                                                        <div class="card-body pb-2">
                                                            <div>{{$product->name}}</div>
                                                            <div class="d-flex justify-content-between p-0 m-0">
                                                                <span>Daily Income</span>
                                                                <span>{{$product->currency->type." ".number_format($product->daily_income)}}</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between p-0 m-0">
                                                                <span>Validity Period</span>
                                                                <span>{{$product->validity}} days</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between p-0 m-0">
                                                                <span>Total Revenue</span>
                                                                <span>{{$product->currency->type." ".number_format($product->returns)}}</span>
                                                            </div>
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
                @include("./navbar")
            </div>
        </div>
    </div>

    <script src="{{asset('assets/js/jquery.js')}}"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/axios.js')}}"></script>
    <script src="{{asset('assets/js/auth.js')}}"></script>
    </body>
</html>
