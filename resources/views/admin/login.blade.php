<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Modernize Free</title>
  <link rel="shortcut icon" type="image/png" href="{{asset('admin/assets/images/logos/favicon.png')}}" />
  <link rel="stylesheet" href="{{asset('admin/assets/css/admin.styles.min.css')}}" />
  <link rel="stylesheet" href="{{asset('admin/assets/css/admin.min.css')}}" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="{{url('assets/images/logos/dark-logo.svg')}}" width="180" alt="">
                </a>
                <p class="text-center">Your Social Campaigns</p>
                <span class="message d-block" style="text-align:center"></span>
                <form action="{{url('/login')}}" method="POST" id="login-form">
                  @csrf
                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                    <span class="error"></span>
                  </div>
                  <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <span class="error"> </span>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                      <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
                      <label class="form-check-label text-dark" for="flexCheckChecked">
                        Remeber this Device
                      </label>
                    </div>
                    <a class="text-primary fw-bold" href="./index.html">Forgot Password ?</a>
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign In</button>
                  <!--<div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">New to Modernize?</p>
                    <a class="text-primary fw-bold ms-2" href="./authentication-register.html">Create an account</a>
                  </div>-->
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{asset('admin/assets/libs/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('admin/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('admin/assets/libs/axios/axios.js')}}"></script>
  <script>
    $(function () {
      $('#login-form').on("submit", function (event) {
        event.preventDefault();
        const form = event.target;
        const url = form.action;
        const inputs = {
          email: $("#email").val(),
          password: $("#password").val()
        };
        let token = $("input[name='_token']").val();

        $('.error').text('');
        $('.message').text('');
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
          $(".message").text(message);
          window.location.href = response.data.redirect;
        })
        .catch(function(error){
          let errors = error.response.data.error;
          if(errors.email){
            document.getElementsByClassName('error')[0].innerHTML = errors.email;
          }
          if(errors.password){
            document.getElementsByClassName('error')[1].innerHTML = errors.password;
          }

          switch(error.response.status){
            case 400:
              $(".message").text(error.response.data.message)
            break;
            case 401:
              $(".message").text(error.response.data.message);
            break;
          }
        });
      });
    });
  </script>
</body>
</html>