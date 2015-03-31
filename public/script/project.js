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

    // Add task button (for adding Project sub-tasks)
    $('.task-add-btn').on('click', addTaskInputs);

    // Add context button (for adding new context)
    $('.context-add-btn').on('click', addContextInputs);

    // Remove context button
    $('.removeContextButton').on('click', removeContext)

        $('form').on('keypress', function(e){
            if ( e.keyCode == 13 ) {
                //e.preventDefault();
            }
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

var newTasks = 0;

// Add task input fields before the task-add-btn button
// a.task-add-btn should be inside an li, span or div
function addTaskInputs(event) {
    event.preventDefault();

    // Initialize global count object if not exists
    if (window.addTaskCount == null) { window.addTaskCount = 0; }
    var prefix = 'newTask_' + window.addTaskCount;
    var containerTagName = $(this).parent().prop('tagName').toLowerCase();
    // If parent container is not li, div or span, exit
    if (containerTagName != 'li' && containerTagName != 'div'
            && containerTagName != 'span') { return false; }

    // jQuery requires the brackets
    var containerTag = '<' + containerTagName + '>';

    // Insert the task widget before task-add-btn
    var newContainer = $(containerTag, { id: prefix } )
        .append(
                $('<input>', { 
                    name: prefix + '_completed',
                    type: 'checkbox',
                    class: 'cb-completed' }
                 )
               )
        .append(
                $('<input>', { 
                    name: prefix + '_description',
                    type: 'text' }
                 )
               )
        .insertBefore($(this).parent());

    // Now append the Contexts widget
    $(newContainer).append(cloneContextsWidget(prefix));
    contextContainer = newContainer;
    window.addTaskCount++;

}

var contextContainer;

// Clone the Contexts template
// DOM must include a 'template' instance of the widget in a
// container.contextsWidgetTemplate
function cloneContextsWidget(prefix) {
    //console.log(prefix);
    var lastIndex = prefix.length - 1;
    if (prefix[lastIndex] != '_') { prefix = prefix + '_'; }

    var element = $('.contextsWidgetTemplate').clone()
        .attr('id', prefix + '_contextsWidget')
        .find('*').each(function() {
            //console.log('for1: ' + $(this).attr('for'));
            if ($(this).attr('for') !== undefined) {
                $(this).attr('for', prefix + $(this).attr('for'));
                //console.log('for2: ' + $(this).attr('for'));
            }
            //console.log('id1: ' + $(this).attr('id'));
            if (this.id !== undefined ) {
                $(this).attr('id', prefix + this.id);
                //console.log('id2: ' + $(this).attr('id'));
            }
            //console.log('name1: ' + $(this).attr('name'));
            if ($(this).attr('name') !== undefined) {
                $(this).attr('name', prefix + $(this).attr('name'));  
                //console.log('name2: ' + $(this).attr('name'));
            }
        })

    return element;
}

// Instead of submitting the form on pressing ENTER, call a function
// Event handler should be passed as 'handler' property of the data parameter
// (3rd parameter in the jQuery.on() call)
function preventSubmitOnEnter(e) {
    if ( e.keyCode == 13 ) {

        // Call the real handler
        e.data['handler'](this);

        // Prevent form from submitting
        return false;
    }
}

var debug;
// Submit AJAX request to add a new context to user's custom list
// 'element' receives 'this' object from calling function
// If successful, update the DOM
function submitAddContext(element) {

    // make an ajax request to add context and on success:
    $.ajax({
        url: "/contexts",
        type: "POST",
        data: {
            '_token': $('[name=_token]').val(),
        'description': $(element).val()
        },
        tryCount: 0,
        retryLimit: 5,
        success: function(data){

            debug = element; console.log(data);
            if (data.success) {
                //TODO: Move this to another function
                var val = $(element).val();;
                // Enable checkbox and rename to match others
                $(element).siblings('input[type=checkbox]')
        .removeAttr('disabled')
        .attr('name', 'context[]')
        .attr('id', 'context_' + data.context_id)
        .val(data.context_id);
                $(element).siblings('label').text(val);
                $(element).toggle();
                $(element).siblings('label').toggle();

                //TODO: add disableContextButton button after label
                //LEFT OFF HERE!!!!!!!!!
            }
            else {
                //TODO: add better error handling
                alert(data.message);
            }

        },
        error: function(xhr, textStatus, errorThrown) {
        }
    });

    // -removes the disabled attribute from checkbox
    // -replaces the label value with the value of the text
    // -toggle label
    // -toggle text
    // -maybe update all context widgets on page?

    return false;

}


// Add context input fields before the context-add-btn button
// a.task-add-btn should be inside an li, span or div
function addContextInputs(event) {
    event.preventDefault();

    // Initialize global count object if not exists
    if (window.addContextCount == null) { window.addContextCount = 0; }
    window.addContextCount++;
    var prefix = 'newContext_' + window.addContextCount;

    // Insert the context widget before context-add-btn
    var newContainer = $('<div>', { class: 'form-group-fluid',
        id: prefix } )
        .append(
                $('<input>', {
                    id: prefix + '_cb',
                name: prefix + '_cb',
                type: 'checkbox',
                disabled: 'disabled'}
                )
               )
        .append('&nbsp;')
        .append(
                $('<input>', { 
                    id: prefix + '_txt',
                name: prefix + '_txt',
                class: 'newContext',
                type: 'text' }
                )
               )
        .append(
                $('<label>', { 
                    id: prefix + '_lbl',
                name: prefix + '_lbl',
                for: prefix + '_',
                style: 'display:none;'}
                )
               )
        .insertBefore($(this).parent());

    // Now add the Contexts widget to the DOM and set focus on text box
    $(newContainer).append(cloneContextsWidget(prefix));
    contextContainer = newContainer;
    window.addTaskCount++;

    //console.log(prefix + '_txt');
    $('#' + prefix + '_txt').focus();

    // We want to call submitAddContext when user presses ENTER on the text box
    // Apparently binding to a class selector on page load doesn't work for
    // dynamically addded elements, so we're binding by ID on creation instead,
    // which, although annoying and a tad messier, is probably much faster.
    // TODO: Figure out why repeating the 2nd parameter seems to work???
    $('#' + prefix + '_txt').on('keypress', null, {'handler': submitAddContext},
            preventSubmitOnEnter);

}

function removeContext(event) {
    console.log('removeContext');
    event.preventDefault();

    var thisButton = this;
    console.log(this);
    console.log($(this));
    var url = "/contexts/" + $(this).val();

    $.ajax({
        url: url,
        type: "DELETE",
        data: {
            '_token': $('[name=_token]').val(),
        'context_id': $(this).val()
        },
        tryCount: 0,
        retryLimit: 5,
        success: function(data){
            if (data.success == true) {
                $(thisButton).parent().slideUp(650);
            }
            else {
                // If AJAX succeeds, but error is returned by server, undo the change event
                console.log('AJAX successful with errors');
            }

        },
        error: function(xhr, textStatus, errorThrown) {

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
