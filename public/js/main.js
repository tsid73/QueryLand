$(".loader").hide();
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    $('#loginform').submit(function (e) {
        e.preventDefault();
        $(".loader").show();
        $("#loginarea").hide();
        var form = $(this);
        var post_url = form.attr('action');
        var post_data = form.serialize();
        $.ajax({
            type: 'POST'
            , url: post_url
            , data: post_data
            , processData: false
            , success: function (response) {
                if (response == "er") {
                    $(".loader").hide();
                    $("#loginarea").show();
                    $("#er").show();
                    document.getElementById("er").innerHTML = "Invalid Email or Password! Try again.";
                }
                else {
                    $(".loader").show();
                    location.reload();
                }
            }
            , error: function (request, status, error) {
                //                        alert(request.responseText);
            }
        });
    });
});

function myFunction() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    }
    else {
        x.className = "topnav";
    }
}

function errorcheck() {
    var x = document.getElementById("er").innerHTML;
    if (x.length > 1) {
        $("#er").hide();
    }
}
var lg = document.getElementById('loginarea').innerHTML;
var resetvar = document.getElementById('reset').innerHTML;

function replacecont() {
    document.getElementById('loginarea').innerHTML = resetvar;
}

function replaceback() {
    document.getElementById('loginarea').innerHTML = lg;
}
var toolbarOptions = [
        ['bold', 'italic', 'underline', 'strike'], // toggled buttons
  ['blockquote', 'code-block'],

  [{
        'header': 1
            }, {
        'header': 2
            }], // custom button values
  [{
        'list': 'ordered'
            }, {
        'list': 'bullet'
            }]
  , [{
        'script': 'sub'
            }, {
        'script': 'super'
            }], // superscript/subscript
  [{
        'indent': '-1'
            }, {
        'indent': '+1'
            }], // outdent/indent
  [{
        'direction': 'rtl'
            }], // text direction

  [{
        'size': ['small', false, 'large', 'huge']
            }], // custom dropdown
  [{
        'header': [1, 2, 3, 4, 5, 6, false]
            }],

  [{
        'color': []
            }, {
        'background': []
            }], // dropdown with defaults from theme
  [{
        'font': []
            }]
  , [{
        'align': []
            }], ['link', 'image', 'formula']
  , ['clean']
    , ];
var quill = new Quill('#editor', {
    modules: {
        toolbar: toolbarOptions
    }
    , theme: 'snow'
});