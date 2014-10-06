$(document).ready(function() {

    // Hide list initially
    $('li.project').hide();

    // INITIALIZE GLOBAL SETTINGS
    window.showContext = 'All';
    window.showCompleted = false;
    window.showRoadblocks = true;

    // Bind refreshVisibility function to projects and trigger to immediately refresh list
    $('li.project').bind('refreshVisibility', refreshVisibility);
    //TODO: check whether calling this before it's defined can affect performance
    $('li.project').trigger('refreshVisibility');

    // Double clicking task description allows edit
    //$('li.project').doubleclick(makeEditable);
    $('li.project').dblclick(function() {
	    alert('dblclick');
	});

    // Clicking 'Show Completed' button 
    $('#show-completed-btn').click(showCompletedToggle);

    // Clicking Context buttons
    $('.context-btn').click(contextButtonClick);

    // Clicking context labels should trigger Context button click as well
    $('.context-label').click(function() {
        $('#context-btn-' + $(this).text()).trigger( "click" )
    });

});










// Toggle checkbox helper function
function toggleCheckbox(box) {
    $(box).prop('checked', !$(box).prop('checked'));
}


function contextButtonClick(event) {
    event.preventDefault();

    // Update global option and refresh list
    window.showContext = $(this).attr('name');
    $('li.project').hide();
    $('li.project').trigger('refreshVisibility');

    // Update buttons
    $('.context-btn.btn-info').removeClass('btn-info');
    $(this).addClass('btn-info');

}

function makeEditable(event) {
    alert($(this).text());
}



function showCompletedToggle(event) {
    event.preventDefault();

    // Update global option and refresh list
    window.showCompleted = !$(this).hasClass('btn-info');
    $('li.project').hide();
    $('li.project').trigger('refreshVisibility');

    $(this).toggleClass('btn-info');

}


// refreshVisibility event shows/hides a project based on global options
function refreshVisibility() {

    // Rules to decide if project li should be visible
    var visible = false;

    // CONTEXT : Start by showing all projects in current context
    //TODO: add multiple context support
    if (window.showContext == 'All') { visible = true; }
    else if ($(this).hasClass(window.showContext)) { visible = true; }

    // COMPLETED : Hide completed tasks if Show Completed not selected
    //TODO: add filtering based on completed timestamp
    if (!window.showCompleted && $(this).hasClass('completed')) { visible = false; }

    //console.log(window.showContext + ': ' + $(this).attr('class') + ' ' + window.showCompleted + '|' + visible);

    //TODO: Add roadblocks piece later



    // Now show/hide based on result
    visible ? $(this).show() : $(this).hide();

}


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
