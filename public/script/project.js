window.showContext = [];
window.showContext['All'] = true;

$(document).ready(function() {

    // Hide list initially
    //$('li.project').hide();

    // INITIALIZE GLOBAL SETTINGS
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
    $('.removeContextButton').on('click', removeContext);

});







// Toggle checkbox helper function
function toggleCheckbox(box) {
    $(box).prop('checked', !$(box).prop('checked'));
}


function contextButtonClick(event) {
    event.preventDefault();

    // Update global option and refresh list
    var context = $(this).attr('name');
    var curVal = window.showContext[context];
    console.log('context = '+context);
    console.log('curVal = '+curVal);
    if (curVal == 'All') {
        for (ctx in window.showContext) {
            console.log('setting '+ctx+' to false');
            window.showContext[ctx] = false;
        }
    }
    else {
        window.showContext['All'] = false;
        window.showContext[context] = curVal ? false : true;
    }
    
    $('li.project').trigger('refreshVisibility');

    // Update buttons
    if (context == 'All') {
        $('.context-btn.btn-info').removeClass('btn-info');
        $(this).addClass('btn-info');
    }
    else {
        $('#context-btn-All').removeClass('btn-info');
        $(this).toggleClass('btn-info');
    }

}

function makeEditable(event) {
    alert($(this).text());
}



function showCompletedToggle(event) {
    event.preventDefault();

    // Update global option and refresh list
    window.showCompleted = !$(this).hasClass('btn-info');
    $('li.project').trigger('refreshVisibility');

    $(this).toggleClass('btn-info');

}


// refreshVisibility event shows/hides a project based on global options
function refreshVisibility() {

    // Rules to decide if project li should be visible
    var visible = false;

    // CONTEXT : Start by showing all projects in current context
    //TODO: add multiple context support
    for (key in window.showContext) {
        //console.log(window.showContext[key]);
    }
    if (window.showContext['All'] == true) { visible = true; }
    else {
        for (context in window.showContext) {
            if (window.showContext[context] && $(this).hasClass(context)) {
                visible = true;
            }
        }
    } 

    // COMPLETED : Hide completed tasks if Show Completed not selected
    if (!window.showCompleted && $(this).hasClass('completed')) { visible = false; }

    //TODO: Add roadblocks piece later



    // Now show/hide based on result
    visible ? $(this).removeClass('hidden') : $(this).addClass('hidden');

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
    
    var lastIndex = prefix.length - 1;
    if (prefix[lastIndex] != '_') { prefix = prefix + '_'; }

    var element = $('.contextsWidgetTemplate').clone()
        .attr('id', prefix + '_contextsWidget')
        .find('*').each(function() {
            
            if ($(this).attr('for') !== undefined) {
                $(this).attr('for', prefix + $(this).attr('for'));
            }
            
            if (this.id !== undefined ) {
                $(this).attr('id', prefix + this.id);
            }
            
            if ($(this).attr('name') !== undefined) {
                $(this).attr('name', prefix + $(this).attr('name'));  
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

            if (data.success) {

                // Update UI to match changed data
                addNewContextToUi(element, data.context_id);

            }
            else {
                //TODO: add better error handling
                alert(data.message);
            }

        },
        error: function(xhr, textStatus, errorThrown) {
        }
    });

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
    var nextTI = parseInt($('input[name=ti_seq]').val());
    $('input[name=ti_seq]').val(nextTI + 1);


    // Insert the context widget before context-add-btn
    var newContainer = $('<div>', { class: 'form-group-fluid',
        id: prefix } )
        .append(
                $('<input>', {
                    id: prefix + '_cb',
                name: prefix + '_cb',
                type: 'checkbox',
                disabled: 'disabled',
                tabindex: nextTI }
                )
               )
        .append('&nbsp;')
        .append(
                $('<input>', { 
                    id: prefix + '_txt',
                name: prefix + '_txt',
                class: 'newContext',
                type: 'text',
                tabindex: nextTI }
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
    
    event.preventDefault();

    var thisButton = this;
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
                // If successful, remove context from UI
                $(thisButton).parent().slideUp(650);
            }
            else {
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

function addNewContextToUi(element, context_id) {

    var val = $(element).val();;
    
    // Enable checkbox and rename to match others
    $(element).siblings('input[type=checkbox]')
        .removeAttr('disabled')
        .attr('name', 'context[]')
        .attr('id', 'context_' + context_id)
        .val(context_id);

    // Replace text box with label
    $(element).siblings('label').text(val);
    $(element).toggle();
    $(element).siblings('label').toggle();

    // Add removeContextButton button after label
    $('<button>', { 
        class: 'removeContextButton',
        id: 'removeContextButton_' + context_id,
        value: context_id,
        text: '-',
        title: 'Remove context'
    }).insertAfter($(element).siblings('label'));

    // Dynamically bind click event to dynamic element
    $('#removeContextButton_' + context_id).on('click', removeContext);

    //TODO: update all context widgets on page

}
