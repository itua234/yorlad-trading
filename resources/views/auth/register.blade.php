<!DOCTYPE html>
<html>
    <head>
        <!-- Mobile Specific Metas -->
        <meta charset="utf-8">
	    <meta name="viewport" content="">
        <meta name="theme-color" content="#3e4684">
        <link rel="shortcut icon" type="image/png" href="{{asset('assets/images/favicon.png')}}"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/css/bootstrap-grid.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/css/bootstrap-reboot.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">
        <title>Vado Global</title>
	    <?php date_default_timezone_set("Africa/Lagos"); ?>
    </head>
    <style>
        .m-t-80{
            margin-top:40px;
        }
    </style>
    <body>

    <section class="m-b-30 m-t-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-xl-6 col-md-7 col-sm-10" style="padding:20px;">
                    <div class="d-flex justify-content-center mb-2">
                        <img src="{{asset('assets/images/vado_logo.png')}}" style="width:350px;" />
                    </div>
                    <form id="signup-form" action="{{url('register')}}" method="POST">
                        @csrf
                        <div class="screen-1">
                            <div class="">
                                <div class="email">
                                    <div class="d-flex">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <ion-icon name="person-outline"></ion-icon>
                                        </div>
                                        <input type="text" id="firstname"
                                        name="firstname" class="w-100" placeholder="FIRSTNAME" />
                                    </div>
                                </div>
                                <span class="error"></span>
                            </div>
                            <div class="mt-2">
                                <div class="email">
                                    <div class="d-flex">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <ion-icon name="person-outline"></ion-icon>
                                        </div>
                                        <input type="text" id="lastname"
                                        name="lastname" class="w-100" placeholder="LASTNAME" />
                                    </div>
                                </div>
                                <span class="error"></span>
                            </div>
                            <div class="mt-2">
                                <div class="email">
                                    <div class="d-flex">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <ion-icon name="call-outline"></ion-icon>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center">+234</div>
                                        <input type="text" id="phone" 
                                        name="phone" class="w-100" placeholder="PHONE" />
                                    </div>
                                </div>
                                <span class="error"></span>
                            </div>
                            <div class="mt-2">
                                <div class="email">
                                    <div class="d-flex">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <ion-icon name="barcode-outline"></ion-icon>
                                        </div>
                                        <input type="text" id="referral"  value="<?=$referral?>"
                                        name="referral" class="w-100" placeholder="INVITATION CODE" />
                                    </div>
                                </div>
                                <span class="error"></span>
                            </div>
                            <div class="mt-2">
                                <div class="email">
                                    <div class="d-flex">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <ion-icon name="lock-closed-outline"></ion-icon>
                                        </div>
                                        <input id="password" type="password" 
                                        name="password" class="w-100" placeholder="PASSWORD" />
                                        <div class="d-flex align-items-center justify-content-center">
                                            <ion-icon class="show-hide" name="eye-outline"></ion-icon>
                                        </div>
                                    </div>
                                </div>
                                <span class="error"></span>
                            </div>
                            <div class="mt-2">
                                <div class="email">
                                    <div class="d-flex">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <ion-icon name="lock-closed-outline"></ion-icon>
                                        </div>
                                        <input id="password_confirmation" type="password"
                                         name="password_confirmation" class="w-100" placeholder="CONFIRM PASSWORD" />
                                    </div>
                                </div>
                                <span class="error"></span>
                            </div>
                            <button class="login mt-2" type="submit">Sign up</button>
                            <div class="footer mt-2">
                                <a href="{{url('login')}}">Login</a>
                                <a href="{{url('reset-password')}}">Forgot Password?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>  
        </div>
    </section>

    
    <script src="{{asset('assets/js/jquery.js')}}"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{asset('assets/js/axios.js')}}"></script>
    <script src="{{asset('assets/js/auth.js')}}"></script>
    <script>
        $(document).ready(function () {
            $(".show-hide").click(function (event) {
                let icon = $(this);
                var input = $("#password");
                if(input.attr("type") === "password"){
                    input.attr("type", "text");
                    icon.attr("name", "eye-off-outline");
                }else{
                    input.attr("type", "password");
                    icon.attr("name", "eye-outline");
                }
            });
        });
    </script>
    </body>
</html>
