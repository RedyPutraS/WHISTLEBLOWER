// cek session laporan
function checksession(token, url, noreg) {
    var resp = [];
    $.ajax({
        type: "POST",
        url: url,
        async: false,
        data: {
            _token: token,
            f_noreg: noreg,
        },
        dataType: "json",
        success: function (response) {
            resp = response;
        },
    });
    return resp;
}


