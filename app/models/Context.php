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
        $myContexts = Context::where('user_id', null)->orWhere('user_id', $userid)->get();

        //TODO: 1. give users option to add/remove contexts as they see fit
        //TODO: 2. Add migration to generate defaults by user and make user_id required
        //TODO: 3. Update the above query to not select on null user_id
        
        // Loop through contexts and generate array
        foreach ($myContexts as $thisContext) {
            $current = array(
                'id' => $thisContext->id,
                'description' => $thisContext->description,
                'checked' => false
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
     * @return String
     */
    public static function addContext($description) {

       //LEFT OFF HERE!!!!!!!!

       $status = 0; 

       return $status;

    }

}
