function sortProject(changeEvent) {

    var data = {};

    // Get old and new index from event
    data.oldIndex = changeEvent.oldIndex;
    data.newIndex = changeEvent.newIndex;

    // Get filters 
    data.filters = {};
    data.filters = getCurrentFilters();

    // Get project id from event item
    data.projectId = $(changeEvent.item).children('input.cb-completed').val();

    console.log(data);

    // Make AJAX call to sort 

    // TODO: Function to match index with task
    // TODO: Function to update sequences on update

    // TODO: make this queue-able

}
