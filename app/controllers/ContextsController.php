<?php

class ContextsController extends BaseController {

    public function __construct() {
    }




    /**
     * addContext
     * Receive an AJAX request to add a custom context for the current user
     *
     * @return JSONString
     */
    public function addContext() {
        
        // Get inputs from request
        $description = Input::get('description');

        // Insert into DB and build/return response
        $status = Context::addContext($description);
        
        $response = array(
            'success' => $status['success'],
            'message' => $status['message']
        );

        if (!empty($status['id'])) {
            $response['context_id'] = $status['id'];
        }

        //TODO: add conditional here to support non-ajax form submit
        return Response::json($response);

    }


    public function removeContext($contextId) {
        
        $response = Context::find($contextId)->disableContext();

        return Response::json($response);
    }

}
