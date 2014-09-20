$(document).ready(function() {

    // Toggle checkbox
    function toggleCheckbox(box) {
        $(box).prop('checked', !$(box).prop('checked'));
    }


    $('.cb-completed').change(function(){

        var thisBox = this;
        var cbValue = $(this).prop('checked') ? "1" : "0";

        console.log('Prop value of ' + $(this).attr('name') + ': ' + $(this).prop('checked') + '. Sending value ' + cbValue);

        $.ajax({
            type: "POST",
            url: "/projects/setCompleted",
            data: {
                '_token': $('[name=_token]').val(),
            'project_id': $(this).val(),
            'value': cbValue
            },
            success: function(data){
                console.log(data.response);
            },
            error: function(data) {
                console.log(data.response);
            },
            dataType: 'json'
        });

    });

});
