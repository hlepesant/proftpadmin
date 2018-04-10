jQuery(document).ready(function () {

    "use strict";

    $('#proftpbundle_ftpuser_identity').on('change blur click', function(){

        var identity = ($('#proftpbundle_ftpuser_identity').val());

        if ( identity.length ) {
            var FirstLastName = identity.split(' ', 2);
            var FirstName = FirstLastName[0].split('', 2);
            var LastName = FirstLastName[1];
            if (typeof LastName == 'undefined' || LastName === null) {
                LastName = $('#proftpbundle_ftpuser_group').find(":selected").text();
            }

            var username = FirstName[0].toLowerCase() + LastName.toLowerCase(); 
            $('#proftpbundle_ftpuser_username').val(username.toLowerCase());
        }
    });

    var pwd_options = {};
    pwd_options.ui = {
        bootstrap4: true,
        container: "#pwd-container",
        viewports: {
            progress: ".pwstrength_viewport_progress"
        },
        showVerdictsInsideProgressBar: true
    };
//    pwd_options.common = {
//        debug: true,
//        onLoad: function () {
//            $('#messages').text('Start typing password');
//        }
//    };
    $(':password').pwstrength(pwd_options);
});
