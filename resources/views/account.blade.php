<!DOCTYPE html>
<html>
    <head>
        <!-- Basic Page Info -->
        <meta charset="utf-8">
	    <meta name="viewport" content="">
        <meta name="theme-color" content="#3e4684">
        <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/favicon.png')}}"/>
        <title>Vado Global - Digital Investment Platform</title>
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
        #copySuccessMessage{
            color: green;
            font-size: 12px;
            position:absolute;
            right:0;
            top:0;
            width:150px;
            display: none;
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
                    <div class="container-fluid">
                        <div class="card mt-2" style="border:none;">
                            <div class="card-body" style="padding:10px 20px;
                            background-color:#3e4684;box-shadow: 0 6px 2em #e6e9f9;color:white;border-radius:20px 20px 0 0 ;">
                                <div class="d-flex justify-content-between">
                                    <span class="">Total Income</span>
                                    <span class="">{{$currency->type}}{{number_format($user->total_income)}}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="">Total Withdrawal</span>
                                    <span class=""><span>{{$currency->type}}</span><span id="total-withdrawal">{{number_format($user->total_withdrawal)}}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="">Referral Income</span>
                                    <span class=""><span>{{$currency->type}}</span><span id="total-withdrawal">{{number_format($user->referral_income)}}</span>
                                </div>
                            </div>
                            <div class="accordion accordion-flush mt-3" id="accordionFlushExample">            
                                <div class="accordion-item">
                                    <h5 class="d-flex justify-content-between accordion-btn" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#flush-collapseTwo" 
                                    aria-expanded="false" aria-controls="flush-collapseTwo">
                                        <span>Bank Details</span>
                                    </h5>
                                    <div id="flush-collapseTwo" class="accordion-collapse collapse" 
                                    aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <form id="add-bank-data" action="{{url('/bank-details')}}" method="POST">
                                                @csrf
                                                <div class="">
                                                    <label for="">Bank Name</label>
                                                    <select class="form-control" name="bank_name">
                                                        <?php 
                                                            foreach($banks as $bank):
                                                                if(isset($user->bank)):
                                                                    if($bank["code"] == $user->bank->bank_code):
                                                                        echo '<option value="'.$bank["code"].'" selected>
                                                                            '.$bank["name"].'
                                                                        </option>';
                                                                    endif;
                                                                endif;
                                                                echo '<option value="'.$bank["code"].'">
                                                                    '.$bank["name"].'
                                                                </option>';
                                                            endforeach;
                                                        ?>
                                                    </select>
                                                    <span class="error"></span>
                                                </div>
                                                <div class="mt-2">
                                                    <label for="">Account Number</label>
                                                    <input type="text" class="form-control" name="account_number"
                                                    value="<?php
                                                        if(isset($user->bank)){
                                                            echo $user->bank->account_number;
                                                        };
                                                    ?>" data-url="{{url('/bank-details/verify')}}">
                                                    <span class="error"></span>
                                                </div>  
                                                <div class="mt-2">
                                                    <label for="">Account Name</label>
                                                    <input type="text" class="form-control" name="account_name" 
                                                    value="<?php
                                                        if(isset($user->bank)){
                                                            echo $user->bank->account_name;
                                                        };
                                                    ?>" readonly>
                                                    <span class="error"></span>
                                                </div>                                     
                                                <div class="w-100 mt-2">
                                                    <button disabled type="submit" class="btn btn-primary w-100">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
                                                <p style="font-size:10px;color:red;">withdrawal takes within 24 hours to be approved, and we also charge 6% withdrawal fee</p>
                                                <div class="w-100 mt-2">
                                                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h5 class="accordion-btn" data-bs-toggle="collapse" 
                                    data-bs-target="#flush-collapseOne" 
                                    aria-expanded="false" aria-controls="flush-collapseOne">
                                        Referral
                                    </h5>
                                    
                                    <div id="flush-collapseOne" class="accordion-collapse collapse" 
                                    aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <div class="d-flex justify-content-between">
                                                <div id="qrcode" class="w-100 d-flex justify-content-center pt-2 pb-2"></div>
                                                <div class="position-relative">
                                                    <span style="cursor:pointer" id="copyReferral" 
                                                        data-id="{{url('/register/'.$user->referral)}}">
                                                        <img src="/assets/admin/images/icons/copy.svg">
                                                    </span>
                                                    <span id="copySuccessMessage">Copied to clipcoard!</span>
                                                </div>
                                            </div>
                                            <div class="text-center">SCAN REFERRAL CODE</div>
                                            <div class="mt-2 w-100">
                                                <input type="text" class="w-100" disabled value="{{url('/register/'.$user->referral)}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h5 class="accordion-btn" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#flush-collapseFour" 
                                    aria-expanded="false" aria-controls="flush-collapseFour">
                                        <span>Withdrawal Pin Setup</span>
                                    </h5>
                                    <div id="flush-collapseFour" class="accordion-collapse collapse" 
                                    aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <form id="withdraw-pin-setup" action="{{url('/withdrawal/pin')}}" method="POST">
                                                @csrf
                                                <div class="">
                                                    <label for="">Withdrawal Pin</label>
                                                    <input type="number" class="form-control" name="pin">
                                                    <span class="error"></span>
                                                </div>
                                                <div class="mt-1">
                                                    <label for="">Confirm Withdrawal Pin</label>
                                                    <input type="number" class="form-control" name="confirm_pin">
                                                    <span class="error"></span>
                                                </div>
                                                <div class="w-100 mt-2">
                                                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="accordion-item">
                                    <h5 class="accordion-btn" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#flush-collapseFive" 
                                    aria-expanded="false" aria-controls="flush-collapseFive">
                                        <span>Download Mobile App</span>
                                    </h5>
                                    <div id="flush-collapseFive" class="accordion-collapse collapse" 
                                    aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <a href="" class="btn btn-primary" download>Download Apk</a>
                                        </div>
                                    </div>
                                </div>-->
                                <div class="accordion-item">
                                    <h5 class="accordion-btn" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#flush-collapseSix" 
                                    aria-expanded="false" aria-controls="flush-collapseSix">
                                        <span>Contact Support</span>
                                    </h5>
                                    <div id="flush-collapseSix" class="accordion-collapse collapse" 
                                    aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <div>
                                                <a href="https://wa.me/+18058059883?text=Hello my name is ......" class="btn btn-primary">
                                                    <span><ion-icon name="logo-whatsapp"></ion-icon></span>
                                                    <span>+18058059883</span>
                                                </a>
                                            </div>
                                            <div class="mt-2">
                                                <a href="mailto:support@vadoglobal.com?subject=Vado Global Support" class="btn btn-primary">
                                                    <span><ion-icon name="mail-outline"></ion-icon></span>
                                                    <span>support@vadoglobal.com</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h5 class="accordion-btn" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#flush-collapseSeven" 
                                    aria-expanded="false" aria-controls="flush-collapseSeven">
                                        <span>Change Password</span>
                                    </h5>
                                    <div id="flush-collapseSeven" class="accordion-collapse collapse" 
                                    aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <form id="change-password" action="{{url('/change-password')}}" method="POST">
                                                @csrf
                                                <div class="">
                                                    <label for="">Current Password</label>
                                                    <input type="text" class="form-control" name="current_password">
                                                    <span class="error"></span>
                                                </div>
                                                <div class="mt-1">
                                                    <label for="">New Password</label>
                                                    <input type="text" class="form-control" name="new_password">
                                                    <span class="error"></span>
                                                </div>
                                                <div class="mt-1">
                                                    <label for="">Confirm New Password</label>
                                                    <input type="text" class="form-control" name="confirm_password">
                                                    <span class="error"></span>
                                                </div>
                                                <div class="w-100 mt-2">
                                                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h5 class="accordion-btn" 
                                    data-bs-toggle="collapse" 
                                    data-bs-target="#flush-collapseEight" 
                                    aria-expanded="false" aria-controls="flush-collapseEight">
                                        <span>Logout</span>
                                    </h5>
                                    <div id="flush-collapseEight" class="accordion-collapse collapse" 
                                    aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            <a href="{{url('/logout')}}" class="btn btn-primary">Logout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
    <script src="{{asset('assets/js/account.js')}}"></script>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script>
        function generateQRCode(){
            const data = "{{url('/register/'.$user->referral)}}";
            const qrcode = new QRCode(document.getElementById("qrcode"), {
                text: data,
                width: 128,
                height: 128
            });
        }
        generateQRCode();
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
