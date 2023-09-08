<DOCTYPE html>
<html>
    <head>
        <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" type="text/css">
    </head>
    <body>
	<form id="reset-pw-form" action="{{url('api/reset-password')}}" method="POST">
		@csrf
		<div class="screen-1">
			<div class="">
				<div class="password">
					<div class="">
						<ion-icon name="call-outline"></ion-icon>+234
						<input id="phone" type="text" name="phone" placeholder="PHONE" />
					</div>
					<div class="">
                        <button class="login" id="send-otp" type="button" data-id="{{url('api/send-reset-otp')}}">Send</button>
                    </div>
				</div>
				<span class="error"></span>
			</div>
			<input type="hidden" id="purpose" name="purpose" value="password_reset" />
			<div class="hidden-form-elements d-none">
				<div class="mt-2">
					<div class="password">
						<div class="">
							<ion-icon name="checkbox-outline"></ion-icon>
							<input id="code" type="text" name="code" placeholder="CODE" />
						</div>
					</div>
					<span class="error"></span>
				</div>
				<div class="mt-2">
					<div class="password">
						<div class="">
							<ion-icon name="lock-closed-outline"></ion-icon>
							<input id="password" type="password" name="password" placeholder="NEW PASSWORD" />
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
							<input id="confirm_password" type="password" name="confirm_password" placeholder="CONFIRM NEW PASSWORD" />
						</div>
					</div>
					<span class="error"></span>
				</div>
				<button class="login mt-2" type="submit">Submit</button>
			</div>
		</div>
	</form>

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
