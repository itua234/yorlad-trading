<!DOCTYPE html>
<html>
    <head>
        <!-- Basic Page Info -->
        <meta charset="utf-8">
	    <meta name="viewport" content="">
        <meta name="theme-color" content="#3e4684">
        <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/favicon.png')}}"/>
        <title>Vado Global - Trading Platform</title>
        <?php date_default_timezone_set("Africa/Lagos"); ?>

        <!-- Mobile Specific Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <!-- CSS -->
        <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/css/dashboard.css')}}" rel="stylesheet" type="text/css">
    </head>
    <body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-xl-6 col-md-8 col-sm-11 pos-relative">
                <div class="top-nav d-flex justify-content-end">
                    <a href="{{url('/account')}}" class="mr-auto d-flex">
                        <div class="h-100 d-flex align-items-center justify-content-center" style="width:40px;">
                            <ion-icon name="wallet" class="icons"></ion-icon>
                        </div>
                        <div style="color:#3e4684;" class="h-100 d-flex align-items-center justify-content-center">
                            <span class="">{{$currency->type}}</span>
                            <span id="balance">{{number_format($user->balance)}}</span>
                        </div>
                    </a>
                    <a href="{{url('/orders/active')}}">
                        <div class="position-relative h-100 d-flex align-items-center justify-content-center" style="width:40px;">
                            <ion-icon name="calendar" class="icons"></ion-icon>
                            <span class="order-count d-flex align-items-center justify-content-center">
                                0
                            </span>
                        </div>
                    </a>
                    <a href="{{url('/withdrawals')}}">
                        <div class="position-relative h-100 d-flex align-items-center justify-content-center" style="width:40px;">
                            <ion-icon name="cash" class="icons"></ion-icon>
                        </div>
                    </a>
                </div>
                <div class="body-container mt-2 pt-2">
                    <div class="">
                        <img class="" 
                        src="{{asset('assets/images/products/' . $product->photo) }}" 
                        style="height:300px;width:100%"
                        alt="Card image cap">
                    </div>
                    <div class="container-fluid pt-3">
                        <div class="row">
                            <div class="col-12" style="border:none;">
                                <div class="">
                                    @csrf
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
                                    <div>
                                        <span style="
                                        text-decoration:line-through;text-decoration-color:red">
                                            @if (!$product->old_price == 0)
                                                {{$product->currency->type." ".number_format($product->old_price)}}
                                            @endif
                                        </span>
                                        
                                        {{$product->currency->type." ".number_format($product->price)}}
                                    </div>
                                </div>
                                <form action="{{url('/order')}}" class="mt-3 d-flex justify-content-center" method="POST" id="order-product">
                                    @csrf
                                    <input type="hidden" id="productId" name="productId" value="{{$product->id}}">
                                    <button type="submit" class="btn btn-primary">Purchase Now</button>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <div class="spin-loader-box d-none">
                    <div class="spin-loader-content">
                        <div class="spin-loader"></div>
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
    <script src="{{asset('assets/js/transaction.js')}}"></script>
    <script>
        function getOrderCount(){
            let token = $("input[name='_token']").val()
            const config = {
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token,
                    "X-Requested-With": "XMLHttpRequest"
                }
            };
            axios.get("{{url('/orders/count')}}", config)
            .then(function(response){
                let message = response.data.message;
                $(".order-count").text(response.data.results);
            })
            .catch(function(error){
                $(".order-count").text(0);
            });
        }
        getOrderCount();
    </script>
    </body>
</html>
