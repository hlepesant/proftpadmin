jQuery(document).ready(function () {

    "use strict";

    //$('#proftpbundle_ftpuser_group').attr("disabled", true); 
    //$('#proftpbundle_ftpuser_group').attr("style", "pointer-events: none;");
    //$('#proftpbundle_ftpuser_group option:not(:selected)').prop('disabled', true);
    //var home = $('#proftpbundle_ftpuser_home').val();

    $('#ftp_user_firstname, #ftp_user_lastname').on('change blur click', function(){

        //var firstname = $('#ftp_user_firstname').val().toLowerCase();
        //var lastname = $('#ftp_user_lastname').val().toLowerCase().replace(/\s/g, '');
        var firstname = $('#ftp_user_firstname').val();
        var lastname = $('#ftp_user_lastname').val().replace(/\s/g, '');

        if ( firstname.length && lastname.length ) {
            var initiale = firstname.split('')[0];
            var username = initiale + lastname; 
            username = removeDiacritics(username);
            $('#ftp_user_username').val(username);
            //$('#ftp_user_home').val( home + '/' + username);
        }
    });

    var pwd_options = {};
    pwd_options.ui = {
        bootstrap4: true,
        container: "#ftp_user_password_first",
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
