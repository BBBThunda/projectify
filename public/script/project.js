// Changing 'Completed' checkboxes sends an AJAX request to update DB
$('.cb-completed').change(toggleProjectCompleted);

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

    // Make the 'changes pending' element visible
window.projectSortChanged = 1;




    // Make AJAX call to sort 

    // TODO: Function to match index with task
    // TODO: Function to update sequences on update

    // TODO: make this queue-able

}

// Function that gets called every x seconds and sends an ajax request to server with new sequence
function resequence()
{
    var sequenceObject = getSequence();

    // Error handling

    // AJAX Call to update server
    $.ajax({
        url: "/projects/resequence",
        type: "POST",
        data: {
            '_token': $('[name=_token]').val(),
        'sequence': sequenceObject
        },
        tryCount: 0,
        retryLimit: 5,
        success: function(data){
            if (data.response == true) {
                window.projectSortChanged = 0;
            }
            else {
                // If AJAX succeeds, but error is returned by server, undo the change event
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


    // On success
    //   make 'changes pending' element hidden
    //   make 'changes saved' element visible
    //   make 'unable to save changes' element hidden

    // On failure
    //   make 'unable to save changes' element visible

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
                // REMOVE RESEQUENCE ELEMENT
            }
            else {
                // If AJAX succeeds, but error is returned by server

                // REPLACE RESEQUENCE ELEMENT WITH ERROR ELEMENT
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
            // REPLACE RESEQUENCE ELEMENT WITH ERROR ELEMENT

            if (xhr.status == 500) {
                //TODO: Log application error to server
            }
        }
    });

}


