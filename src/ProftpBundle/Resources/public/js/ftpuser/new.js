jQuery(document).ready(function () {

    "use strict";

    //$('#proftpbundle_ftpuser_group').attr("disabled", true); 
    //$('#proftpbundle_ftpuser_group').attr("style", "pointer-events: none;");
    $('#proftpbundle_ftpuser_group option:not(:selected)').prop('disabled', true);

    var home = $('#proftpbundle_ftpuser_home').val();

    $('#proftpbundle_ftpuser_firstname, #proftpbundle_ftpuser_lastname').on('change blur click', function(){

        var firstname = $('#proftpbundle_ftpuser_firstname').val().toLowerCase();
        var lastname = $('#proftpbundle_ftpuser_lastname').val().toLowerCase().replace(/\s/g, '');
        //lastname = lastname.replace(/\s/g, '');

        if ( firstname.length && lastname.length ) {
            var initiale = firstname.split('')[0];
            var username = initiale + lastname; 
            username = removeDiacritics(username);
            $('#proftpbundle_ftpuser_username').val(username);

            $('#proftpbundle_ftpuser_home').val( home + '/' + username);
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
