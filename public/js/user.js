 function dispprofile() {
     $('#profile').show();
     $('#topics').hide();
 }

 function disptopics() {
     $("#profile").hide();
     $('#topics').show();
 }
 $(document).ready(function () {
     $('[data-toggle="tooltip"]').tooltip({
         trigger: "focus"
     });
 });
 $(document).ready(function () {
     jQuery.validator.addMethod("noSpace", function (value, element) { //Code used for blank space Validation 
         return value.indexOf(" ") < 0 && value != "";
     }, "No space please and don't leave it empty");
 });
 $(document).ready(function () {
     $("#editform").validate({
         rules: {
             name: {
                 minlength: 5
             }
             , username: {
                 required: true
                 , minlength: 5
                 , noSpace: true
             }
             , email: {
                 required: true
                 , email: true
             }
             , institute: "minlength: 6"
             , specs: "minlength: 4"
         }
         , messages: {
             name: {
                 minlength: "Your username must consist of at least 5 characters"
             }
             , username: {
                 required: "Please enter a username"
                 , minlength: "Your username must consist of at least 5 characters"
                 , noSpace: "No space please and don't leave it empty"
             }
             , email: "Please enter a valid email address"
             , institute: "Enter atleast 6 character"
             , specs: "Enter atleast 4 character"
         }
     });
 });

 function deletefun(id) {
     document.getElementById('tid').value = id;
     $("#deleteid").submit();
 }
 $('#name').keypress(function (e) {
     var regex = new RegExp("^[A-Za-z? ]+$");
     var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
     if (!regex.test(key)) {
         event.preventDefault();
         return false;
     }
 });
 $('#username').keypress(function (e) {
     var regex = new RegExp("^[A-Za-z0-9?_@-]+$");
     var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
     if (!regex.test(key)) {
         event.preventDefault();
         return false;
     }
 });
 $('#institute,#specs').keypress(function (e) {
     var regex = new RegExp("^[A-Za-z? .]+$");
     var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
     if (!regex.test(key)) {
         event.preventDefault();
         return false;
     }
 });

 $('#emails').keypress(function (e) {
     var regex = new RegExp("^[A-Za-z0-9?.@-_]+$");
     var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
     if (!regex.test(key)) {
         event.preventDefault();
         return false;
     }
 });

 function addtopic() {
     var checkedVals = $('.theClass:checkbox:checked').map(function () {
         return this.value;
     }).get();
     var sendval = checkedVals.join(",");
     document.getElementById('add').value = sendval;
     document.getElementById('addtopic').submit();
 }
 $(document).ready(function () {
     $('[data-toggle="popover"]').popover();
 });

 function readFile() {
     var arr;
     var file = this.files[0];
     var fileType = file["type"];
     var ValidImageTypes = ["image/jpeg", "image/png"];
     if ($.inArray(fileType, ValidImageTypes) < 0) {
         alert('The image should be either JPEG/PNG');
         return false;
     }
     if (this.files && this.files[0]) {
         var FR = new FileReader();
         FR.addEventListener("load", function (e) {
        arr = e.target.result;
        var s = arr.toString();
         let base64Length = s.length - (s.indexOf(',') + 1);
         let padding = (s.charAt(s.length - 2) === '=') ? 2 : ((s.charAt(s.length - 1) === '=') ? 1 : 0);
         let fileSize = base64Length * 0.75 - padding;
         if (fileSize > 1000000) {
             alert("File Size exceeded Max 1mb");
             return false;
         }
             document.getElementById("pro").src = e.target.result;
             document.getElementById("b64").value = e.target.result;
         });
         FR.readAsDataURL(this.files[0]);
     }
 }
 document.getElementById("img").addEventListener("change", readFile);


$(document).ready(function () {
        $('[data-toggle="popover"]').popover();
    });

    function showlogin() {
        document.getElementById('model').click();
    }

    function checkusername() {
        var x = document.getElementById('username').value;
        $.ajax({
            type: 'post'
            , url: '/checkuser'
            , data: {
                username: x
            }
            , success: function (data) {
                if(data == "yes")
                    {
                        $('#ero').show();
                        $("#username").focus();
                    } else if(data == "no"){
                    $('#ero').hide();
                }
            }
        , });
    }

    function checkemail() {
          var x = document.getElementById('emails').value;
        $.ajax({
            type: 'post'
            , url: '/checkemail'
            , data: {
                email: x
            }
            , success: function (data) {
                if(data == "yes")
                    {
                        $('#erro').show();
                        $("#emails").focus();
                    } else if(data == "no"){
                    $('#erro').hide();
                }
            }
        , });
    }