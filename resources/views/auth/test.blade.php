<DOCTYPE html>
<html>
    <head>
        <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/css/bootstrap-grid.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/css/bootstrap-reboot.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">
    </head>
    <body>

    <section class="m-b-30 m-t-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-xl-6 col-md-7 col-sm-10" style="padding:20px;">
                    <form id="signup-form" action="{{url('register')}}" method="POST">
                        @csrf
                        <div class="screen-1">
                            <div class="">
                                <div class="email">
                                    <div class="sec-2">
                                        <ion-icon name="call-outline"></ion-icon>
                                        <input type="text" id="firstname"
                                        name="firstname" placeholder="Firstname" />
                                    </div>
                                </div>
                                <span class="error"></span>
                            </div>
                            <div class="mt-2">
                                <div class="email">
                                    <div class="sec-2">
                                        <ion-icon name="call-outline"></ion-icon>
                                        <input type="text" id="lastname"
                                        name="lastname" placeholder="Lastname" />
                                    </div>
                                </div>
                                <span class="error"></span>
                            </div>
                            <div class="mt-2">
                                <div class="email">
                                    <div class="sec-2">
                                        <ion-icon name="call-outline"></ion-icon>+234
                                        <input type="text" id="phone" name="phone" placeholder="PHONE" />
                                    </div>
                                </div>
                                <span class="error"></span>
                            </div>
                            <div class="mt-2">
                                <div class="email">
                                    <div class="sec-2">
                                        <ion-icon name="call-outline"></ion-icon>
                                        <input type="text" id="referral"  value="<?=$referral?>"
                                        name="referral" placeholder="Invitation Code" />
                                    </div>
                                </div>
                                <span class="error"></span>
                            </div>
                            <div class="mt-2">
                                <div class="password">
                                    <div class="">
                                        <ion-icon name="lock-closed-outline"></ion-icon>
                                        <input id="password" type="password" name="password" placeholder="PASSWORD" />
                                    </div>
                                    <div id="">
                                        <ion-icon class="show-hide" name="eye-outline"></ion-icon>
                                    </div>
                                </div>
                                <span class="error"></span>
                            </div>
                            <div class="mt-2">
                                <div class="password">
                                    <div class="sec-2">
                                        <ion-icon name="lock-closed-outline"></ion-icon>
                                        <input id="password_confirmation" type="password" name="password_confirmation" placeholder="CONFIRM PASSWORD" />
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
            $(".show-hide").click(function () {
                var input = $("#password");
                if(input.attr("type") === "password"){
                    input.attr("type", "text");
                }else{
                    input.attr("type", "password");
                }
            });
        });
    </script>
    </body>
</html>
