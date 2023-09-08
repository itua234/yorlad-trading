<DOCTYPE html>
<html>
    <head>
        <!-- Basic Page Info -->
        <meta charset="utf-8">
        <title>DeskApp - Bootstrap Admin Dashboard HTML Template</title>
        <?php date_default_timezone_set("Africa/Lagos"); ?>

        <!-- Site favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{asset('vendors/images/apple-touch-icon.png')}}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{asset('vendors/images/favicon-32x32.png')}}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{asset('vendors/images/favicon-16x16.png')}}">

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
                    <div class="mr-auto d-flex">
                        <div class="h-100 d-flex align-items-center justify-content-center" style="width:40px;">
                            <ion-icon name="wallet-outline" class="icons"></ion-icon>
                        </div>
                        <div class="h-100 d-flex align-items-center justify-content-center">
                            <span class="">{{$currency->type}}</span>
                            <span id="balance">{{number_format($user->balance)}}</span>
                        </div>
                    </div>
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
                            <ion-icon name="cash-outline" class="icons"></ion-icon>
                        </div>
                    </a>
                </div>
                <div class="body-container mt-2">
                    <div class="container-fluid">
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
                                                    <a class="card" style="border:none;" href="{{url('/product/'.$product->uuid)}}">
                                                        <img class="card-img-top" src="{{asset('assets/images/products/' . $product->photo) }}" alt="Card image cap">
                                                        <div class="card-body">
                                                            <div>{{$product->name}}</div>
                                                            <div class="d-flex justify-content-between p-0 m-0">
                                                                <span>Daily Income</span>
                                                                <span>{{$product->currency->type." ".$product->daily_income}}</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between p-0 m-0">
                                                                <span>Validity Period</span>
                                                                <span>{{$product->validity}} days</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between p-0 m-0">
                                                                <span>Total Revenue</span>
                                                                <span>{{$product->currency->type." ".$product->returns}}</span>
                                                            </div>
                                                            <div>
                                                                <span style="
                                                                text-decoration:line-through;text-decoration-color:red">
                                                                    @if (!$product->old_price == 0)
                                                                        {{$product->currency->type." ".$product->old_price}}
                                                                    @endif
                                                                </span>
                                                                
                                                                {{$product->currency->type." ".$product->price}}
                                                            </div>
                                                        </div>
                                                    </a>
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
