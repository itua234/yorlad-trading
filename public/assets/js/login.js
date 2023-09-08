$(function () {
    //axios.defaults.headers.common["Authorization"] = "Bearer " + token;
    $('#signin-form').on("submit", function (event) {
        event.preventDefault();
        let btn = $("#signin-form button[type='submit']");
        btn.attr("disabled", true);
        const form = event.target;
        const url = form.action;
        const inputs = {
            phone: $("#phone").val(),
            password: $("#password").val()
        };
        alert(JSON.stringify(inputs));

        $('.error').text('');
        $('.message').text('');
        const config = {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json"
            }
        };
        axios.post(url, inputs, config)
        .then(function(response){
            let message = response.data.message;
            $(".message").text(message);
            //window.location.href = "/dashboard";
        })
        .catch(function(error){
            alert(error);
            let errors = error.response.data.error;
            if(errors.phone){
                document.getElementsByClassName('error')[0].innerHTML = errors.phone;
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
            btn.attr("disabled", false);
        });
    });
})