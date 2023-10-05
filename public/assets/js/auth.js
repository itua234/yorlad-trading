$(function () {
    const baseUrl = "http://172.20.10.2:8080/api/v1";
    //axios.defaults.headers.common["Authorization"] = "Bearer " + token;

    $('#signup-form').on("submit", function (event) {
        event.preventDefault();
        let btn = $("#signup-form button[type='submit']");
        btn.attr("disabled", true);
        btn.text("Loading....");
        const form = event.target;
        const url = form.action;
        const inputs = {
            firstname: $("#firstname").val(),
            lastname: $("#lastname").val(),
            phone: $("#phone").val(),
            password: $("#password").val(),
            referral: $("#referral").val(),
            password_confirmation: $("#password_confirmation").val()
        };
        let token = $("input[name='_token']").val()

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
            //Swal.fire(message);
            window.location.href = response.data.redirect;
        })
        .catch(function(error){
            let errors = error.response.data.error;
            if(errors.firstname){
                document.getElementsByClassName('error')[0].innerHTML = errors.firstname;
            }
            if(errors.lastname){
                document.getElementsByClassName('error')[1].innerHTML = errors.lastname;
            }
            if(errors.phone){
                document.getElementsByClassName('error')[2].innerHTML = errors.phone;
            }
            if(errors.referral){
                document.getElementsByClassName('error')[3].innerHTML = errors.referral;
            }
            if(errors.password){
                document.getElementsByClassName('error')[4].innerHTML = errors.password;
            }
            if(errors.password_confirmation){
                document.getElementsByClassName('error')[5].innerHTML = errors.password_confirmation;
            }

            switch(error.response.status){
                case 400:
                    $(".message").text(error.response.data.message)
                break;
                case 401:
                    $(".message").text(error.response.data.message);
                break;
            }
            btn.attr("disabled", false);
            btn.text("Sign up")
        });
    });

    function startTimer(btn){
        var countdown = 240;
        var countdownInterval = setInterval(function(){
            btn.text(countdown + " S");
            countdown--;

            if(countdown < 0){
                clearInterval(countdownInterval);
                btn.text("Send");
                btn.attr("disabled", false);
            }
        }, 1000);
    }

    $('#send-otp').on("click", function (event) {
        event.preventDefault();
        let btn = $(this);
        btn.text("Sending...")
        btn.attr("disabled", true);
        const url = btn.data("id");
        const inputs = {
            phone: $("#phone").val(),
            purpose: $("#purpose").val() 
        };

        $('.error').text('');
        const config = {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json"
            }
        };
        axios.post(url, inputs, config)
        .then(function(response){
            let message = response.data.message;
            Swal.fire("Success");
            $(".hidden-form-elements").removeClass("d-none");
            startTimer(btn);
        })
        .catch(function(error){
            let errors = error.response.data.error;
            if(errors.phone){
                document.getElementsByClassName('error')[0].innerHTML = errors.phone;
            }
            btn.text("Send");
            btn.attr("disabled", false);
        });
    });

    $('#signin-form').on("submit", function (event) {
        event.preventDefault();
        let btn = $("#signin-form button[type='submit']");
        btn.text("Signing in....");
        btn.attr("disabled", true);
        const form = event.target;
        const url = form.action;
        const inputs = {
            phone: $("#phone").val(),
            password: $("#password").val()
        };
        let token = $("input[name='_token']").val()

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
            //Swal.fire(message);
            window.location.href = response.data.redirect;
        })
        .catch(function(error){
            let errors = error.response.data.error;
            if(errors.phone){
                document.getElementsByClassName('error')[0].innerHTML = errors.phone;
            }
            if(errors.password){
                document.getElementsByClassName('error')[1].innerHTML = errors.password;
            }
        
            switch(error.response.status){
                case 400:
                    document.getElementsByClassName('error')[1].innerHTML = error.response.data.message;
                break;
            }
            btn.text("Sign in");
            btn.attr("disabled", false);
        });
    });

    $('#reset-pw-form').on("submit", function (event) {
        event.preventDefault();
        let btn = $("#reset-pw-form button[type='submit']");
        btn.attr("disabled", true);
        const form = event.target;
        const url = form.action;
        const inputs = {
          phone: $("#phone").val(),
          password: $("#password").val(),
          confirm_password: $("#confirm_password").val(),
          code: $("#code").val()
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
            Swal.fire(message);
            window.location.href = response.data.redirect;
        })
        .catch(function(error){
            let errors = error.response.data.error;
            if(errors.phone){
                document.getElementsByClassName('error')[0].innerHTML = errors.phone;
            }
            if(errors.code){
                document.getElementsByClassName('error')[1].innerHTML = errors.code;
            }
            if(errors.password){
                document.getElementsByClassName('error')[2].innerHTML = errors.password;
            }
            if(errors.confirm_password){
                document.getElementsByClassName('error')[3].innerHTML = errors.confirm_password;
            }

            switch(error.response.status){
                case 400:
                    $(".message").text(error.response.data.message)
                break;
                case 401:
                    $(".message").text(error.response.data.message);
                break;
            }
            btn.attr("disabled", false);
        });
    });


})