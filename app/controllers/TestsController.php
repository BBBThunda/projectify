<?php

class TestsController extends BaseController {

    /*
    |--------------------------------------------------------------------------
    | Tests Controller
    |--------------------------------------------------------------------------
    |
    |
     */

    public function test() {

        $inputs = array('contexts' => array('1','2','4'));
        $project = Project::find(3);
        $project->updateContexts($inputs['contexts']);

    }

}
