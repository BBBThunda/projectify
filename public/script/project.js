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
            if (data.response == true) {
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
        console.log(curElement);
        //console.log({id: $(curElement).find('input[type =checkbox]').val(), sequence: i});
        project.push({id: $(curElement).find('input[type =checkbox]').val(), sequence: i});
    }
    //console.log(project);
}

// LEFT OFF HERE!!! Copied from toggleProjectCompleted
function testResequence() {

    var listObj = $('.cb-completed');
    var sequences = [];

    for (var i = 0; i < listObj.length; i++) {
        sequence = $(listObj[i]).attr('data-sequence');
        projectID = $(listObj[i]).val();

        sequences.push({sequence: sequence, projectID: projectID});
    }

    $.ajax({
        url: "/test",
        type: "POST",
        data: {
            '_token': $('[name=_token]').val(),
        'sequences': sequences
        },
        tryCount: 0,
        retryLimit: 5,
        success: function(data){
            if (data.response == true) {
console.log('SUCCESS!!!');
            }
            else {
                // If AJAX succeeds, but error is returned by server, undo the change event
console.log('Unsuccessful response');
            }

        },
        error: function(xhr, textStatus, errorThrown) {
            // If AJAX call fails, undo the change event
console.log('Ajax request failed');


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
console.log('500 Server error');
            }
            else {
                //TODO: Call error popup widget here
console.log('WTF?');
            }
        }
    });

}


