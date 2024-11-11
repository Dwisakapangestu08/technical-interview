$(document).ready(function () {
    $("#check_password").on("click", function () {
        if ($(this).is(":checked")) {
            $(".password").attr("type", "text");
        } else {
            $(".password").attr("type", "password");
        }
    });

    $("#formRegister").on("submit", function (e) {
        e.preventDefault();
        let link_api = $("meta[name='link-api']").attr("link");

        $.ajax({
            url: link_api,
            data: new FormData(this),
            type: "POST",
            dataType: "JSON",
            contentType: false,
            processData: false,
            success: function (res) {
                if (res.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil!",
                        text: res.message,
                        timer: 5000,
                        showCancelButton: false,
                        showConfirmButton: false,
                    }).then(function () {
                        window.location.href = "/";
                    });
                } else {
                    console.log("error");
                    if (res.validasi) {
                        validasi(res.errors);
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Gagal",
                            text: res.message,
                        });
                    }
                }
            },
        });
    });

    const validasi = (message) => {
        $.each(message, function (key, val) {
            $("." + key + "_err").text(val);
        });
    };
});
