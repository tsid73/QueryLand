$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(".app").on("click", function () {
    var id = $(this).attr('id');
    var split_id = id.split("_");
    var text = split_id[0];
    var quesid = split_id[1];
    $("#"+id).addClass('disabled');
    $.ajax({
        type: 'post'
        , url: '/admin/index/questionsajax'
        , data: 'id=' + quesid
        , success: function (data) {
            if (data == "ok") {
                document.getElementById('read_' + quesid ).click();
//                $("#"+id).addClass('disabled');
            }
        }
    });
});

function markread(id) {
    $.ajax({
        type: 'get'
        , url: '/notification/' + id
        , data: {}
        , success: function (response) {
            window.location.reload();
        }
    });
}
var unread = document.getElementById('viewunread').innerHTML;
var all = document.getElementById('viewall').innerHTML;

function view() {
    document.getElementById('viewunread').innerHTML = all;
}

function un() {
    document.getElementById('viewunread').innerHTML = unread;
}
$(document).ready(function () {
    jQuery.validator.addMethod("noSpace", function (value, element) { //Code used for blank space Validation 
        return value.indexOf(" ") < 0 && value != "";
    }, "No space please and don't leave it empty");
});
$(document).ready(function () {
    $("#adminedit").validate({
        rules: {
            user: {
                required: true
                , minlength: 5
                , noSpace: true
            }
            , psw: {
                required: true
                , minlength: 6
                , equalTo: "#pswc"
            }
        }
        , messages: {
            user: {
                required: "Please enter a username"
                , minlength: "Your username must consist of at least 5 characters"
                , noSpace: "No space please and don't leave it empty"
            }
            , psw: {
                required: "Password is required"
                , minlength: "Your password must consist of at least 6 characters"
                , equalTo: "Password didnt match"
            }
        }
    });
});