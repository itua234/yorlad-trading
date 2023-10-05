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
    <style>
        .accordion-btn{
            box-shadow: 0 6px 2em #e6e9f9;
            padding: 8px 10px; 
            cursor:pointer;
        }
    </style>
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
                    <div class="card" style="border:none;">
                        <div class="card-body">
                            <div class="accordion accordion-flush mt-3" id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h5 class="accordion-btn" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#flush-collapseThree" 
                                    aria-expanded="false" aria-controls="flush-collapseThree">
                                        <span>Withdrawal</span>
                                    </h5>
                                    <div id="flush-collapseThree" class="accordion-collapse collapse" 
                                    aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <form id="withdraw" action="{{url('/withdraw')}}" method="POST">
                                                @csrf
                                                <div class="">
                                                    <label for="">Amount</label>
                                                    <input type="number" class="form-control" name="amount">
                                                    <span class="error"></span>
                                                </div>
                                                <div class="mt-1">
                                                    <label for="">Withdrawal Pin</label>
                                                    <input type="number" class="form-control" name="pin">
                                                    <span class="error"></span>
                                                </div>
                                                <div class="w-100 mt-2">
                                                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>     
                    </div>
                    <div class="container-fluid">
                        @foreach ($withdrawals as $withdrawal)
                            <div class="card mt-2 open-order-modal"
                            style="border:none;border-radius:20px;
                            box-shadow: 0 6px 2em #e6e9f9;font-size:13px;cursor:pointer">
                                <div class="card-body" style="padding:10px 20px;">
                                    <div class="">
                                        @csrf
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between p-0 m-0">
                                                <span>Amount</span>
                                                <span>{{$currency->type." ".number_format($withdrawal->amount)}}</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span>Status</span>
                                                <span>
                                                    @if($withdrawal->status == "pending")
                                                        <span class="badge bg-warning">{{$withdrawal->status}}</span>
                                                    @elseif($withdrawal->status == "success")
                                                        <span class="badge bg-success">{{$withdrawal->status}}</span>
                                                    @else
                                                        <span class="badge bg-danger">{{$withdrawal->status}}</span>
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between p-0 m-0">
                                                <span>Account Name</span>
                                                <span>{{$withdrawal->user->bank->account_name}}</span>
                                            </div>
                                            <div class="d-flex justify-content-between p-0 m-0">
                                                <span>Account Number</span>
                                                <span>{{$withdrawal->user->bank->account_number}}</span>
                                            </div>
                                            <div class="d-flex justify-content-between p-0 m-0">
                                                <span>Bank Name</span>
                                                <span>{{$withdrawal->user->bank->bank_name}}</span>
                                            </div>
                                            <div class="d-flex justify-content-between p-0 m-0">
                                                <span>Date</span>
                                                <span>{{$withdrawal->created_at}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
    <script>
        $('#withdraw').on("submit", function (event) {
            event.preventDefault();
            let btn = $("#withdraw button[type='submit']");
            //$(".spin-loader-box").removeClass("d-none");
            btn.attr("disabled", true);
            btn.text("Loading...");
            const form = event.target;
            const url = form.action;
            const inputs = {
                amount: $("#withdraw input[name='amount']").val(),
                pin: $("#withdraw input[name='pin']").val(),
            };
            let token = $("input[name='_token']").val()

            $(".error").text("");
            const config = {
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": token,
                    "X-Requested-With": "XMLHttpRequest"
                }
            };
            axios.post(url, inputs, config)
            .then(function(response){
                let message = response.data.message;
                let user = response.data.results;
                $("#balance").text(user.balance.toLocaleString());
                $("#total-withdrawal").text(user.total_withdrawal.toLocaleString());
                //$(".spin-loader-box").addClass("d-none");
                Swal.fire(message);
                btn.attr("disabled", false);
                btn.text("Submit");
            })
            .catch(function(error){
                let errors = error.response.data.error;
                if(errors.amount){
                    document.getElementsByClassName('error')[0].innerHTML = errors.amount;
                }
                if(errors.pin){
                    document.getElementsByClassName('error')[1].innerHTML = errors.pin;
                }
                //$(".spin-loader-box").addClass("d-none");
                btn.attr("disabled", false);
                btn.text("Submit");
            });
        });
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
