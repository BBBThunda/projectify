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
		$name = Input::get('name');

		if (!$project || $project->user_id !== Auth::id()) {
			if (Request::ajax()) {
				return Response::make('Unauthorized', 401);
			}
			else {
				return Redirect::to('/home');
			}
		}

		// Update DB and build/return response
		$status = Context::addContext($name);

		$response = array(
			'response' => $status
		);

		//TODO: add conditional here to support non-ajax form submit
		return Response::json($response);

	}

}
