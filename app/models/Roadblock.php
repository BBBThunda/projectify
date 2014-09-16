<?php

class Roadblock extends Eloquent { 

    public function projects() {
        return $this->belongsToMany('Project');
    }
}
