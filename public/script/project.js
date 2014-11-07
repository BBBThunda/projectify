// Hopefully moving this here will prevent 'hidden' projects from being
// displayed before the page is fully loaded
// Hide list initially
$('li.project').hide();

$(document).ready(function() {

    // Hide list initially
    //$('li.project').hide();

    // INITIALIZE GLOBAL SETTINGS
    window.showContext = 'All';
    window.showCompleted = false;
    window.showRoadblocks = true;

    // Bind refreshVisibility to projects, trigger to immediately refresh list
    $('li.project').bind('refreshVisibility', refreshVisibility);
    //TODO: check whether calling this before defined can affect performance
    $('li.project').trigger('refreshVisibility');

    // Clicking 'Show Completed' button 
    $('#show-completed-btn').click(showCompletedToggle);

    // Clicking Context buttons
    $('.context-btn').click(contextButtonClick);

    // Clicking context labels should trigger Context button click as well
    $('.context-label').click(function() {
        $('#context-btn-' + $(this).text()).trigger( "click" )
    });

    // Add task button (for adding Project sub-tasks)
    $('.task-add-btn').on('click',addTaskInputs);

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

var newTasks = 0;

// Add task input fields before the task-add-btn button
// a.task-add-btn should be inside an li, span or div
function addTaskInputs(event) {
    event.preventDefault();

    // Initialize global count object if not exists
    if (window.addTaskCount == null) { window.addTaskCount = 1; }
    var suffix = 'newTask_' + window.addTaskCount;
    var containerTagName = $(this).parent().prop('tagName').toLowerCase();
    // If parent container is not li, div or span, exit
    if (containerTagName != 'li' && containerTagName != 'div'
            && containerTagName != 'span') { return false; }

    // jQuery requires the brackets
    var containerTag = '<' + containerTagName + '>';

    // Insert the task widget before task-add-btn
    var newContainer = $(containerTag, { id: suffix } )
        .append(
                $('<input>', { 
                    name: 'completed_' + suffix,
                    type: 'checkbox',
                    class: 'cb-completed' }
                 )
               )
        .append(
                $('<input>', { 
                    name: 'description_' + suffix,
                    type: 'text' }
                 )
               )
        .insertBefore($(this).parent());

    // Now append the Contexts widget
    $(newContainer).append(cloneContextsWidget(suffix));

    window.addTaskCount++;

}

// Clone the Contexts template
// Must have a 'template' instance of the widget in a container.contextsWidget
function cloneContextsWidget(suffix) {
    console.log(suffix);

    var element = $('.contextsWidgetTemplate').clone()
        .attr('id', 'contextsWidget_' + suffix)
        .find('*').each(function() {
            console.log('for1: ' + $(this).attr('for'));
            if ($(this).attr('for') !== undefined) {
                $(this).attr('for', $(this).attr('for') + suffix);
                console.log('for2: ' + $(this).attr('for'));
            }
            console.log('id1: ' + $(this).attr('id'));
            if (this.id !== undefined ) {
                $(this).attr('id', this.id + suffix);
                console.log('id2: ' + $(this).attr('id'));
            }
            console.log('name1: ' + $(this).attr('name'));
            $(this).attr('name', 
                $(this).attr('name').split('[')[0] + suffix + '[]');
            console.log('name2: ' + $(this).attr('name'));
        })

    return element;
}
