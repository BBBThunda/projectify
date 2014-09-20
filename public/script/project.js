$(document).ready(function() {

    // Toggle checkbox
    function toggleCheckbox(box) {
        $(box).prop('checked', !$(box).prop('checked'));
    }


    // Changing 'Completed' checkboxes sends an AJAX request to update DB
    $('.cb-completed').change(function(){

        var thisBox = this;
        var cbValue = $(this).prop('checked') ? "1" : "0";

        $.ajax({
            url: "/projects/setCompleted",
            type: "POST",
            data: {
                '_token': $('[name=_token]').val(),
                'project_id': $(this).val(),
                'value': cbValue
            },
            tryCount: 0,
            retryLimit: 5,
            success: function(data){
                console.log(data.response);
            },
            error: function(xhr, textStatus, errorThrown) {
                // If AJAX call fails, undo the change in the UI
                toggleCheckbox(thisBox);


                if (textStatus == 'timeout') {
                    this.tryCount++;
                    if (this.tryCount <= this.retryLimit) {
                        //try again
                        $.ajax(this);
                        return;
                    }            
                    return;
                }
                if (xhr.status == 500) {
                    //TODO: Implement error popup widget (like android toast) and call it here
                } 
                else {
                    //TODO: Call error popup widget here
                }
            }
        });

    });



});
