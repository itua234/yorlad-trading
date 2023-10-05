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

    $('#order-product').on("submit", function (event) {
        event.preventDefault();
        let btn = $("#order-product button[type='submit']");
        $(".spin-loader-box").removeClass("d-none");
        btn.attr("disabled", true);
        const form = event.target;
        const url = form.action;
        const inputs = {
            productId: $("#productId").val()
        };
        let token = $("input[name='_token']").val()

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
            $(".spin-loader-box").addClass("d-none");
            //Swal.fire(response.data.results);
            window.location.href = response.data.redirect;
        })
        .catch(function(error){
            $(".spin-loader-box").addClass("d-none");
            btn.attr("disabled", false);
        });
    });



})