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
                <div class="body-container mt-2">
                    <div class="container-fluid">
                        @foreach ($transactions as $transaction)
                            <div class="card mt-2 open-order-modal" data-url="{{url('/order/task/'.$transaction->id)}}"
                            style="border:none;border-radius:20px;
                            box-shadow: 0 6px 2em #e6e9f9;font-size:13px;cursor:pointer">
                                <div class="card-body" style="padding:10px 20px;">
                                    <div class="">
                                        @csrf
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between p-0 m-0">
                                                <span>Product</span>
                                                <span>{{$transaction->product->name}}</span>
                                            </div>
                                            <div class="d-flex justify-content-between p-0 m-0">
                                                <span>Amount</span>
                                                <span>{{$transaction->product->currency->type." ".number_format($transaction->product->price)}}</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>Last Clicked</span>
                                                <span>
                                                    @if($transaction->last_clicked == date("Y-m-d"))
                                                        <span class="badge bg-success" style="font-size: 12px;">{{date("M d Y", strtotime($transaction->last_clicked))}}</span>
                                                    @else
                                                        <span class="badge bg-warning" style="font-size: 12px;">{{date("M d Y", strtotime($transaction->last_clicked))}}</span>
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between p-0 m-0">
                                                <span>Purchase Date</span>
                                                <span>{{date("M d Y", strtotime($transaction->created_at))}}</span>
                                            </div>
                                            <div class="d-flex justify-content-between p-0 m-0">
                                                <span>Valid Until</span>
                                                <span>
                                                    <?php 
                                                        $originalDate = $transaction->created_at;
                                                        $numberOfDaysToAdd = $transaction->product->validity;
                                                        $timestamp = strtotime($originalDate);
                                                        $newTimestamp = strtotime("+$numberOfDaysToAdd days", $timestamp);

                                                        echo date("M d Y", $newTimestamp)." (".$transaction->product->validity." Days)";
                                                    ?>
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between p-0 m-0">
                                                <span>Daily Reward</span>
                                                <span>{{$transaction->product->currency->type." ".number_format($transaction->product->daily_income)}}</span>
                                            </div>
                                            <div class="d-flex justify-content-between p-0 m-0">
                                                <span>Maximum Revenue</span>
                                                <span>{{$transaction->product->currency->type." ".number_format($transaction->product->returns)}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>



                    <!-- Modal -->
                    <div class="modal fade order-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ...
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="spin-loader-box d-none">
                        <div class="spin-loader-content">
                            <div class="spin-loader"></div>
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
    <script src="{{asset('assets/js/transaction.js')}}"></script>
    <script>
        $(".open-order-modal").on("click", function(event){
            event.preventDefault();
            let card = $(this);
            $(".spin-loader-box").removeClass("d-none");
            let url = $(this).data("url");
            let token = $("input[name='_token']").val();
            const config = {
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token,
                    "X-Requested-With": "XMLHttpRequest"
                }
            };
            axios.get(url, config)
            .then(function(response){
                let message = response.data.message;
                let user = response.data.results.user;
                let transaction = response.data.results.transaction;
                $("#balance").text(user.balance.toLocaleString());
                $(".spin-loader-box").addClass("d-none");
                card.find(".last-clicked").text(transaction.last_clicked);
                Swal.fire({
                    icon: 'success',
                    title: message
                });
                card.find(".badge").removeClass("bg-warning").addClass("bg-success");
            })
            .catch(function(error){
                $(".spin-loader-box").addClass("d-none");
                btn.attr("disabled", false);
            });
            //$(".order-modal").modal("show");
        })
    </script>
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
