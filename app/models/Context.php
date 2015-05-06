<?php

class Context extends Eloquent { 

    public function projects() {
        return $this->belongsToMany('Project');
    }


    /**
     * Provide an array of context id's along with their description and whether
     * each should be checked
     * Intention is to remove repeatable object manipulation from
     * Controllers/Views
     * $project_contexts should be result of Project::contexts if there exists a
     * current project
     *
     * @param Integer
     * @param Illuminate\Database\Eloquent\Collection (optional)
     *
     * @return array
     */
    public static function getUserContexts($userid, $project_contexts = null) {

        // Initialize return array
        $output = array();

        // Get all contexts available to the user
        $myContexts = Context::where(function($query) {
            $query->where('user_id', Auth::id())
                ->orWhere('user_id', null);
        }) 
            ->where('enabled', 1)
            ->orderBy('id') //TODO: Order by most used context
            ->get();

        //TODO: 1. Add migration to generate default contexts by user
        //         and make user_id required
        //TODO: 2. Update the above query to not select on null user_id

        // Loop through contexts and generate array
        foreach ($myContexts as $thisContext) {
            $current = array(
                'id' => $thisContext->id,
                'description' => $thisContext->description,
                'checked' => false,
                'owner' => $thisContext->user_id
            );

            if (!empty($project_contexts)
                && $project_contexts->contains($current['id'])) {
                    $current['checked'] = true;
                }

            array_push($output, $current);
        }

        return $output;

    }


    /**
     * addContext
     *
     * @return array()
     */
    public static function addContext($description) {

        // User must be logged in to add a Context
        $user = Auth::id();
        if (empty($user)) {
            return array(
                'success' => false,
                'message' => 'must be logged in to add context' );
        }

        // Check whether context already exists
        $context = Context::where(function($query) {
            $query->where('user_id', null)
                ->orWhere('user_id', Auth::id());
        })
            ->where('description', trim($description))
            ->first();

        if($context) {

            if ($context->enabled == true) {
                return array(
                    'success' => false,
                    'message' => 'context already exists'
                );
            }

            // Re-enable context
            $context->enabled = true;
            $context->save();
            return array(
                'success' => true,
                'message' => 'context re-enabled',
                'id' => $context->id
            );

        }

        // If context doesn't exist, create it
        $context = new Context();
        $context->user_id = $user;
        $context->description = $description;
        $status = $context->save();

        if ($status == true) { 
            return array(
                'success' => true,
                'message' => 'context added',
                'id' => $context->id
            );
        }
        else {
            //TODO: Add better error handling/logging for SQL errors 
            return array(
                'success' => false,
                'message' => 'failed to add context'
            );
        }

    }

    /**
     * disableContext
     *
     * @return array()
     */
    public function disableContext() {

        // User must be logged in to modify contexts
        $user = Auth::id();
        if (empty($user)) {
            return array(
                'success' => false,
                'message' => 'must be logged in to modify contexts' );
        }
        elseif (empty($this->user_id)) {
            return array(
                'success' => false,
                'message' => 'system contexts can not be modified' );
        }
        elseif ($this->user_id != $user) {
            return array(
                'success' => false,
                'message' => 'unauthorized context' );
        }

        if ($this->enabled == false) {
            return array(
                'success' => true,
                'message' => 'context already disabled' );
        }

        // If context has never been used, delete.  Otherwise, disable

        $result = DB::table('context_project')
            ->select(DB::raw('id'))
            ->where('context_id', $this->id)
            ->first();

        if (!$result) {

            // DELETE
            $this->delete();

            return array(
                'success' => true,
                'message' => 'context deleted');
        }

        // DISABLE
        $this->enabled = false;
        $this->save();

        return array(
            'success' => true,
            'message' => 'context disabled');

    }

}
