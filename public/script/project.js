var syncInterval = 8000;

$(document).ready(function() {
   
    // Changing 'Completed' checkboxes sends an AJAX request to update DB
    $('.cb-completed').change(toggleProjectCompleted);

    window.setInterval(function() {
        resequenceCheck();        
    }, syncInterval);
});

function toggleProjectCompleted() {

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
            if (data.success == true) {
                $(thisBox).parent().toggleClass('completed');
            }
            else {
                // If AJAX succeeds, but error is returned by server, undo the change event
                toggleCheckbox(thisBox);
            }

        },
        error: function(xhr, textStatus, errorThrown) {
            // If AJAX call fails, undo the change event
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

}


function sortProject(changeEvent) {

    // Make the 'updates pending' element visible
    resequencePending();

}

// Check whether changes are pending, if so, sync them
function resequenceCheck() {
    if(!$('.js-updates-pending').hasClass('hidden') &&
            !window.resequenceCheckRunning) {
                window.resequenceCheckRunning = true;
                resequence();
                window.resequenceCheckRunning = false;
            }
}

function resequenceFail() {
    $('.js-updates').removeClass('hidden');
    $('.js-updates-pending').addClass('hidden');
    $('.js-updates-failed').removeClass('hidden');
}

function resequenceSuccess() {
    $('.js-updates').addClass('hidden');
    $('.js-updates-pending').addClass('hidden');
    $('.js-updates-failed').addClass('hidden');
}

function resequencePending() {
    $('.js-updates').removeClass('hidden');
    $('.js-updates-pending').removeClass('hidden');
    $('.js-updates-failed').addClass('hidden');
}

// Get new sequence as an array of objects
function getSequence() {
    var project = [];
    var element = $('li.project');
    for (var i=0; i<element.length; i++) {
        var curElement = element[i];
        project.push({id: $(curElement).find('input[type =checkbox]').val(), sequence: i});
    }
}



function resequence() {

    var listObj = $('.cb-completed');
    var sequences = {};

    for (var i = 0; i < listObj.length; i++) {
        sequence = i+1;
        projectID = $(listObj[i]).val();

        sequences[sequence] = projectID;
    }

    $.ajax({
        url: "/resequence",
        type: "POST",
        data: {
            '_token': $('[name=_token]').val(),
        'sequences': sequences
        },
        tryCount: 0,
        retryLimit: 5,
        success: function(data){
            if (data.success == true) {
                resequenceSuccess();
            }
            else {
                // If AJAX succeeds, but error is returned by server
                resequenceFail();
            }

        },
        error: function(xhr, textStatus, errorThrown) {
            // If AJAX call fails, retry
            if (textStatus == 'timeout') {
                this.tryCount++;
                if (this.tryCount <= this.retryLimit) {
                    //try again
                    $.ajax(this);
                    return;
                }
                return;
            }

            // If last AJAX attempt fails
            resequenceFail();

        }
    });

}


