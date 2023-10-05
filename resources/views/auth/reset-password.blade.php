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
            margin-top:80px;
        }
		.screen-1 .send-otp {
			padding: 1em;
			background: #3e4684;
			color: white;
			border: none;
			border-radius: 30px;
			font-size: 12px;
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
					<form id="reset-pw-form" action="{{url('api/reset-password')}}" method="POST">
						@csrf
						<div class="screen-1">
							<div class="">
								<div class="email">
									<div class="d-flex">
										<div class="d-flex align-items-center justify-content-center">
											<ion-icon name="call-outline"></ion-icon>
										</div>
										<input id="phone" type="text" class="w-100" name="phone" placeholder="PHONE" />
										
										<button class="send-otp" id="send-otp" type="button" data-id="{{url('api/send-reset-otp')}}">Send</button>
									</div>
								</div>
								<span class="error"></span>
							</div>
							<input type="hidden" id="purpose" name="purpose" value="password_reset" />
							<div class="hidden-form-elements d-none">
								<div class="mt-2">
									<div class="email">
										<div class="d-flex">
											<div class="d-flex align-items-center justify-content-center">
												<ion-icon name="barcode-outline"></ion-icon>
											</div>
											<input id="code" type="text" 
											name="code" class="w-100" placeholder="CODE" />
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
											<input id="password" class="w-100" type="password" name="password" placeholder="NEW PASSWORD" />
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
											<input id="confirm_password" class="w-100" type="password" name="confirm_password" placeholder="CONFIRM NEW PASSWORD" />
										</div>
									</div>
									<span class="error"></span>
								</div>
								<button class="login mt-2" type="submit">Submit</button>
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
