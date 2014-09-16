<?php

class Context extends Eloquent { 

    public function projects() {
        return $this->belongsToMany('Project');
    }




    public static function getUserContexts($userid) {
        return array(
            0 => array(
                'id' => 1,
                'description' => 'Home',
                'checked' => true
            ),
            1 => array(
                'id' => 2,
                'description' => 'Work',
                'checked' => false
            ),
            2 => array(
                'id' => 3,
                'description' => 'Phone',
                'checked' => false
            ),
            3 => array(
                'id' => 4,
                'description' => 'Computer',
                'checked' => false
            )
        );
    }
}
