<?php

class ProjectTag extends Eloquent { 

    //protected $table = 'project_tag';

    /**
     * validate
     * Validate inputs before allowing create
     *
     * @param array() $data
     * @return Validator
     */
    public static function validate($data)
    {
        // Validation rules
        $rules = array(

/*            'user_id' => array('required', 'in:' . Auth::id()),
            'sequence' => 'integer',
            'description' => array('required', 'min:1', 'max:255'),
            'completed' => 'boolean'
 */
        );

        return Validator::make($data, $rules);
    }

}
