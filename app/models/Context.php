<?php

class Context extends Eloquent { 

    //protected $fillable = array('user_id', 'parent_project', 'sequence', 'description', 'completed');
    
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
