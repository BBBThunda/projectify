<?php

class Project extends Eloquent { 

    protected $fillable = array('user_id', 'parent_project', 'sequence', 'description', 'completed');




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
    public static function validate($data)
    {
        // Validation rules
        $rules = array(

            'user_id' => array('required', 'in:' . Auth::id()),
            'sequence' => 'integer',
            'description' => array('required', 'min:1', 'max:255'),
            'completed' => 'boolean'

        );

        return Validator::make($data, $rules);
    }

}
