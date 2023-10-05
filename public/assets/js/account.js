$(function () {
    const baseUrl = "http://172.20.10.2:8080/api/v1";
    //axios.defaults.headers.common["Authorization"] = "Bearer " + token;

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

    $("input[name='account_number']").on("input", function (event) {
        const target = $(this);
        const account = target.val();
        const url = $(this).data("url");
        let btn = $("#add-bank-data button[type='submit']");

        if(account.length == 10){
            const inputs = {
                account_number: account,
                bank_name: $("select[name='bank_name']").val()
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
                let account = response.data.results;
                $("input[name='account_name']").val(account.account_name);
                btn.attr("disabled", false);
            })
            .catch(function(error){
                let errors = error.response.data.error;
                if(errors.account_number){
                    document.getElementsByClassName('error')[1].innerHTML = errors.account_number;
                }
                if(errors.account_name){
                    document.getElementsByClassName('error')[2].innerHTML = errors.account_name;
                }
                //$(".spin-loader-box").addClass("d-none");
                btn.attr("disabled", true);
            });
        }
    });

    $('#add-bank-data').on("submit", function (event) {
        event.preventDefault();
        let btn = $("#add-bank-data button[type='submit']");
        //$(".spin-loader-box").removeClass("d-none");
        btn.attr("disabled", true);
        const form = event.target;
        const url = form.action;
        const inputs = {
            //account_name: $("input[name='account_name']").val(),
            account_number: $("input[name='account_number']").val(),
            bank_name: $("select[name='bank_name']").val()
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
            let account = response.data.results;
            $("input[name='account_name']").val(account.account_name);
            //$(".spin-loader-box").addClass("d-none");
            Swal.fire(response.data.message);
            btn.attr("disabled", false);
        })
        .catch(function(error){
            let errors = error.response.data.error;
            if(errors.account_number){
                document.getElementsByClassName('error')[1].innerHTML = errors.account_number;
            }
            if(errors.bank_name){
                document.getElementsByClassName('error')[0].innerHTML = errors.bank_name;
            }
            if(errors.account_name){
                document.getElementsByClassName('error')[2].innerHTML = errors.account_name;
            }
            //$(".spin-loader-box").addClass("d-none");
            btn.attr("disabled", false);
        });
    });

    function copyData(element)
    {
        //Create a temporary input element to copy the text
        var tempInput = $("<input>");
        $("body").append($tempInput)
        tempInput.val(element.val()).select();

        //Copy the selected text to the clipboard
        document.execCommand("copy");

        //Remove the temporary input element
        tempInput.remove();

        $("#copySuccessMessage").fadeIn().delay(1500).fadeOut();
    }

    $("#copyReferral").on("click", function(event){
        let referral = $(this);

        //Create a temporary input element to copy the text
        var tempInput = $("<input>");
        $("body").append(tempInput)
        tempInput.val(referral.data("id")).select();

        //Copy the selected text to the clipboard
        document.execCommand("copy");

        //Remove the temporary input element
        tempInput.remove();

        $("#copySuccessMessage").fadeIn().delay(1500).fadeOut();
    })


    $('#withdraw-pin-setup').on("submit", function (event) {
        event.preventDefault();
        let btn = $("#withdraw-pin-setup button[type='submit']");
        //$(".spin-loader-box").removeClass("d-none");
        btn.attr("disabled", true);
        btn.text("Loading...");
        const form = event.target;
        const url = form.action;
        const inputs = {
            pin: $("#withdraw-pin-setup input[name='pin']").val(),
            confirm_pin: $("#withdraw-pin-setup input[name='confirm_pin']").val(),
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
            //$(".spin-loader-box").addClass("d-none");
            Swal.fire(message);
            btn.attr("disabled", false);
            btn.text("Submit");
        })
        .catch(function(error){
            let errors = error.response.data.error;
            if(errors.pin){
                document.getElementsByClassName('error')[5].innerHTML = errors.pin;
            }
            if(errors.confirm_pin){
                document.getElementsByClassName('error')[6].innerHTML = errors.confirm_pin;
            }
            //$(".spin-loader-box").addClass("d-none");
            btn.attr("disabled", false);
            btn.text("Submit");
        });
    });


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
                document.getElementsByClassName('error')[3].innerHTML = errors.amount;
            }
            if(errors.pin){
                document.getElementsByClassName('error')[4].innerHTML = errors.pin;
            }
            //$(".spin-loader-box").addClass("d-none");
            btn.attr("disabled", false);
            btn.text("Submit");
        });
    });


    $('#change-password').on("submit", function (event) {
        event.preventDefault();
        let btn = $("#change-password button[type='submit']");
        btn.attr("disabled", true);
        btn.text("Loading...");
        const form = event.target;
        const url = form.action;
        const inputs = {
            current_password: $("#change-password input[name='current_password']").val(),
            new_password: $("#change-password input[name='new_password']").val(),
            confirm_password: $("#change-password input[name='confirm_password']").val(),
        };
        let token = $("input[name='_token']").val();

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
            Swal.fire(message);
            btn.attr("disabled", false);
            btn.text("Submit");
        })
        .catch(function(error){
            let errors = error.response.data.error;
            if(errors.current_password){
                document.getElementsByClassName('error')[7].innerHTML = errors.current_password;
            }
            if(errors.new_password){
                document.getElementsByClassName('error')[8].innerHTML = errors.new_password;
            }
            if(errors.confirm_password){
                document.getElementsByClassName('error')[9].innerHTML = errors.confirm_password;
            }
            btn.attr("disabled", false);
            btn.text("Submit");
        });
    });
})