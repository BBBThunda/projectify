var pSettings = {};
var allConst = '_All';
var expireDays = 30;
loadSettingsFromCookies();
if (getSetting('showContext', allConst) === null) {
    changeSetting('showContext', true, allConst);
}
updateButtonStyles();

 
$(document).ready(function() {

    // INITIALIZE GLOBAL SETTINGS
    if (getSetting('showCompleted') === null) {
        changeSetting('showCompleted', false);
    }
    //changeSetting('showRoadblocks', true);

    // Bind refreshVisibility to projects, trigger to immediately refresh list
    $('li.project').bind('refreshVisibility', refreshVisibility);
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
        var contextButtonSelector = '#context-btn-' + $(this).text().trim();
        $(contextButtonSelector).trigger('click');
    });

    // Add task button (for adding Project sub-tasks)
    $('.task-add-btn').on('click', addTaskInputs);

    // Add context button (for adding new context)
    $('.context-add-btn').on('click', addContextInputs);

    // Remove context button
    $('.removeContextButton').on('click', removeContext);

    //TODO: Move this such that it's only called by user home page
    // Make list sortable
    if ($('#project-list-main').length > 0) {
        makeListSortable('project-list-main');
    }

});





// Change a user setting in the global variable and in the session/cookie
function changeSetting(name, newValue, index) {
    var cookieName = null;

    if (index) {
        if (pSettings[name] === undefined) {
            pSettings[name] = {};
        }
        pSettings[name][index] = newValue;
        cookieName = name + '~' + index;
    }
    else {
        pSettings[name] = newValue;
        cookieName = name;
    }

    createCookie(cookieName, newValue, expireDays);
}

// Get a user setting from the global, or if empty, check the session/cookie
function getSetting(name, index) {
    var cookieName = null;
    var globalValue = null;

    if (index) {
        if (pSettings[name] === undefined) {
            pSettings[name] = {};
        }
        cookieName = name + '~' + index;
        globalValue = pSettings[name][index];
    }
    else {
        cookieName = name;
        globalValue = pSettings[name];
    }
    
    if (globalValue != undefined) {
        return globalValue;
    }

    cookieValue = readCookie(name);

    if (index) {
        pSettings[name][index] = cookieValue;
    }
    else {
        pSettings[name] = cookieValue;
    }

    return cookieValue;
}

function loadSettingsFromCookies() {
   var cookies = document.cookie.split('; ');
   for (i = 0; i < cookies.length; i++) {
       var thisCookie = cookies[i].split('=');
       var thisValue = thisCookie.pop();
       if (thisValue === "true") {
           thisValue = true;
       } else if (thisValue === "false") {
           thisValue = false;
       }
       var thisName = thisCookie.join('=');;
       var thisNameParts = thisName.split('~');
       var thisRoot = thisNameParts.shift();
       var thisIndex = thisNameParts.join('~');
       if (thisIndex != '') {
           if (pSettings[thisRoot] === undefined) {
               pSettings[thisRoot] = {};
           }
           pSettings[thisRoot][thisIndex] = thisValue;
       } else {
           pSettings[thisRoot] = thisValue;
       }
   }
}

// Check the settings and make sure the active class matches the setting
function updateButtonStyles() {
    // Context filter buttons
    $('.context-btn').each(function(){
        var context = $(this).attr('name');
        var setting = getSetting('showContext', context);
        if (setting) {
            $(this).addClass('btn-info');
        } else {
            $(this).removeClass('btn-info');
        }
    });

    // Show Completed button
    var showCompletedButton = $('#show-completed-btn'),
        showCompletedSetting = getSetting('showCompleted');
    if (showCompletedSetting) {
        showCompletedButton.addClass('btn-info');
    } else {
        showCompletedButton.removeClass('btn-info');
    }

}


// Toggle checkbox helper function
function toggleCheckbox(box) {
    $(box).prop('checked', !$(box).prop('checked'));
}


function contextButtonClick(event) {
    event.preventDefault();

    // Update global option and refresh list
    var context = $(this).attr('name');
    var settingName = 'showContext';
    var curVal = getSetting(settingName, context);
    if (context === allConst) {
        for (ctx in pSettings.showContext) {
            changeSetting(settingName, false, ctx);
        }
        changeSetting(settingName, true, allConst);
    }
    else {
        changeSetting(settingName, false, allConst);
        var toggle = curVal ? false : true;
        changeSetting(settingName, toggle, context);
    }
    
    $('li.project').trigger('refreshVisibility');

    // Update buttons
    if (context === allConst) {
        $('.context-btn.btn-info').removeClass('btn-info');
        $(this).addClass('btn-info');
    }
    else {
        $('#context-btn-' + allConst).removeClass('btn-info');
        $(this).toggleClass('btn-info');
    }

}

function makeEditable(event) {
    alert($(this).text());
}



function showCompletedToggle(event) {
    event.preventDefault();

    // Update global option and refresh list
    changeSetting('showCompleted', !$(this).hasClass('btn-info'));
    $('li.project').trigger('refreshVisibility');

    $(this).toggleClass('btn-info');

}


// refreshVisibility event shows/hides a project based on global options
function refreshVisibility() {

    // Rules to decide if project li should be visible
    var visible = false;

    // CONTEXT : Start by showing all projects in current context
    //TODO: add multiple context support
    for (key in pSettings.showContext) {
        //console.log(pSettings.showContext[key]);
    }
    if (pSettings.showContext[allConst] == true) { visible = true; }
    else {
        for (context in pSettings.showContext) {
            if (pSettings.showContext[context] && $(this).hasClass(context)) {
                visible = true;
            }
        }
    } 

    // COMPLETED : Hide completed tasks if Show Completed not selected
    if (!pSettings.showCompleted && $(this).hasClass('completed')) { visible = false; }

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
    if (pSettings.addTaskCount == null) { pSettings.addTaskCount = 0; }
    var prefix = 'newTask_' + pSettings.addTaskCount;
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
    pSettings.addTaskCount++;

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
/**
 * Submit AJAX request to add a new context to user's custom list
 * 'element' receives 'this' object from calling function
 * If successful, update the DOM
 *
 * @param element
 */
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


/**
 * Add context input fields before the context-add-btn button
 * a.task-add-btn should be inside an li, span or div
 *
 * @param object event
 */
function addContextInputs(event) {
    event.preventDefault();

    // Initialize global count object if not exists
    if (pSettings.addContextCount == null) { pSettings.addContextCount = 0; }
    pSettings.addContextCount++;
    var prefix = 'newContext_' + pSettings.addContextCount;
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
    pSettings.addTaskCount++;

    $('#' + prefix + '_txt').focus();

    // We want to call submitAddContext when user presses ENTER on the text box
    // Apparently binding to a class selector on page load doesn't work for
    // dynamically addded elements, so we're binding by ID on creation instead,
    // which, although annoying and a tad messier, is probably much faster.
    // TODO: Figure out why repeating the 2nd parameter seems to work???
    $('#' + prefix + '_txt').on('keypress', null, {'handler': submitAddContext},
            preventSubmitOnEnter);

}

/**
 * Remove a context from the user's context list
 *
 * @param object event
 */
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


/**
 * Add a context to the context selection widget
 *
 * @param Element element
 * @param int context_id
 */
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


// COOKIE HELPERS
/**
 * Add or replace a cookie in the document
 *
 * @param string name
 * @param string value
 * @param int days
 *
 * @return 
 */
function createCookie(name, value, days) {
    var expires;
    var msPerDay = 24 * 60 * 60 * 1000;

    if(days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * msPerDay));

        expires = '; expires=' + date.toGMTString();
    }
    else {
        expires = '';
    }

    document.cookie = encodeURIComponent(name) + '=' + encodeURIComponent(value)
        + expires + '; path=/';

}


/**
 * Return the value of a cookie stored in the document
 *
 * @param name string
 *
 * @return string
 */
function readCookie (name, index) {
    var nameEQ = encodeURIComponent(name) + '=';
    var cookies = document.cookie.split(';');

    for (var i = 0; i < cookies.length; i++) {
        var curCookie = cookies[i];
        while (curCookie.charAt(0) === ' ') {
            curCookie = curCookie.substring(1,curCookie.length);
        }
        if (curCookie.indexOf(nameEQ) === 0) {
            return decodeURIComponent(curCookie.substring(nameEQ.length,
                        curCookie.length));
        }

    }
    return null;
}


/**
 * Erase a cookie by setting its value to null and setting the expires value
 * to a time in the past
 *
 * @param string name
 *
 * @return int
 */
function eraseCookie(name) {
    createCookie(name, '', -1);

    if (document.cookie.indexOf('; ' + name + '=') === -1)
    {
        return 0;
    }
    return 1;
}


/**
 * Iterate through each cookie in the document and clear each one.
 * Return 0 for success, error code for failure
 *
 * @return int
 */
function clearCookies() {
    var cookies = document.cookie.split('; ');
    for (i = 0; i < cookies.length; i++) {
       var thisCookie = cookies[i].split('=');
       var thisValue = thisCookie.pop();
       if (thisValue === "true") {
           thisValue === true;
       } else if (thisValue === "false") {
           thisValue === false;
       }
       var thisName = thisCookie.join('=');

       eraseCookie(thisName);
    }

    if (document.cookie === '') {
        return 0;
    }
    return 1;
}


function makeListSortable(elementId) {
    // Make the element with the provided ID sortable using the Sortable library
    var sortable = Sortable.create(document.getElementById(elementId), {
        handle: ".drag-project",
        onUpdate: sortProject
    });

}
var debug;

/**
 * Get the filters currently set by the user
 *
 * @return object 
 */
function getCurrentFilters() {
    var filters = {
        contexts: null,
        roadblocks: null,
        completed: null
    };
   
    // Hopefully we don't need a loop for these

    filters.contexts = pSettings.showContext;
    filters.roadblocks = pSettings.showRoadblocks;
    filters.completed = pSettings.showCompleted;

    return filters;
}
