<?php

use Carbon\Carbon;

class Project extends Eloquent { 

	protected $fillable = array(
		'user_id', 'parent_project', 'sequence', 'description', 'completed'
	);




	/*****************************
	 * MANY TO MANY RELATIONSHIPS
	 *****************************/

	/**
	 * roadblocks
	 * Get array of roadblocks for a project
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function roadblocks()
	{
		return $this->belongsToMany('Roadblock');
	}

	/**
	 * tags
	 * Get array of tags for a project
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function tags()
	{
		return $this->belongsToMany('Tag');
	}

	/**
	 * contexts
	 * Get array of contexts for a project
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function contexts()
	{
		return $this->belongsToMany('Context');
	}




	/**
	 * validate
	 * Validate inputs before allowing create
	 *
	 * @param array() $data
	 * @return Validator
	 */
	public static function validate($data, $type = 'insert')
	{
		// Validation rules depend on what we're about to do

		// Create project (task)
		if ($type == 'insert') {
			$rules = array(
				'user_id' => array('required', 'in:' . Auth::id()),
				'sequence' => 'integer',
				'description' => array('required', 'min:1', 'max:255'),
				'completed' => 'boolean'
			);
		}
		elseif ($type == 'update') {
			$rules = array(
				'sequence' => 'integer',
				'description' => array('required', 'min:1', 'max:255'),
				'completed' => 'boolean'
			);
		}

		return Validator::make($data, $rules);
	}

	/**
	 * setCompleted
	 * Change the value of 'completed' for this project
	 *
	 * @param $value (boolean)
	 * @return boolean
	 */
	public function setCompleted($value) {

		// Only update if value is changing
		if ($value == $this->completed) {
			Log::warning('Completed value for project id ' . $this->id 
				. ' already set to ' . $value);
			return false;
		}

		// Update value and if completed, update timestamp too
		$this->completed = $value;
		if ($value == true) {
			$this->completed_at = new Carbon;
		}
		$this->save();

		return true;

		//TODO: If there are incomplete child tasks, complete them as well
		//(maybe do this in controller?)

	}





	/**
	 * Take array of context id's and update contexts for project accordingly
	 * User must pass in result of getContextChanges() method
	 *
	 * @param array
	 *
	 * @return Project
	 */
	public function updateContexts(array $contextChanges = [])
    {
        if (empty($contextChanges)) {
            return false;
        }

		$time = new Carbon;

		//For some reason Eloquent doesn't update the created_at and updated_at
		//columns when you attach/detach many-to-many keys, so we're overriding
		//that behavior here

		// Make the changes
		if (!empty($contextChanges['detach'])) {
			$this->contexts()->detach($contextChanges['detach'], array(
				'created_at' => $time,
				'updated_at' => $time
			));
		}
		if (!empty($contextChanges['attach'])) {
			$this->contexts()->attach($contextChanges['attach'], array(
				'created_at' => $time,
				'updated_at' => $time
			));
		}

		// Be happy (maybe add some error handling later?)
		return true;
	}





	/**
	 * Takes an array of context id's
	 * Returns changes to be made to DB to update Project::contexts
	 * Returns 2 arrays indexed by 'attach' and 'detach'
	 *
	 * @param array
	 *
	 * @return array(array)
	 */
	public function getContextChanges(array $inputs = null) {

		if (empty($inputs)) { 
			$inputs = array(); 
		}

		$changes = array(
			'attach' => array(),
			'detach' => array()
		);
		$contexts = $this->contexts;

		// Build list of contexts to attach
		foreach($inputs as $input) {
			$found = false;
			foreach($contexts as $context) {
				if ($input == $context->id) {
					$found = true;
				}
			}
			if ($found === false) {
				array_push($changes['attach'], $input);
			}
		}

		// Build list of contexts to detach
		foreach($contexts as $context) {
			$found = false;
			foreach($inputs as $input) {
				if ($context->id == $input) {
					$found = true;
				}
			}
			if ($found === false) {
				array_push($changes['detach'], $context->id);
			}
		}

		return $changes;

	}



	public static function storeProject(array $data = null, array $context = [], Project $project = null) {

		// CREATE PROJECT
		$message = 'Project created!';

		// TODO: Figure out how to make these transactions atomic

		if($project) {
			$action = 'update';
			// Make sure authenticated user owns the project
			if (Auth::id() != $project->user_id) {
				//TODO: handle this error in the controller
				//TODO: log error
				return Redirect::to('/home');
			}
		}
		else {
			$action = 'create';
			$project = new Project;
			$project->user_id = Auth::id();
		}

		//Is there a cleaner way to do this?
		if (!empty($data['parent_project_id'])) {
			$project->parent_project_id = $data['parent_project_id'];
		}
		if (!empty($data['sequence'])) {
			$project->sequence = $data['sequence'];
		}
		if (!empty($data['description'])) {
			$project->description = $data['description'];
		}
		if (!empty($data['completed'])) {
			$project->completed = $data['completed'] | false;
		}

		$project->save();


		// CONTEXTS
		// If the project's contexts have changed, update those
		$contextChanges = $project->getContextChanges($context);
		if ($action == 'create' && !empty($contextChanges['detach'])) {
			throw new Exception("New Project should not have contexts!");
		}
		else {
			// Update project's contexts relationship
			$project->updateContexts($contextChanges);
		}


		// ROADBLOCKS


		// TAGS


		$project->message = $message;
		return $project;
	}

}
