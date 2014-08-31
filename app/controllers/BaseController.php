<?php

class BaseController extends Controller {

    /**
     * Use the master layout by default (doesn't seeem to do anything... need to investigate)
     */
    //protected $layout = 'layouts.master';



        
    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
            if ( ! is_null($this->layout))
            {
                    $this->layout = View::make($this->layout);
            }
    }




    /**
     * Catch-all if method does not exist
     */
    public function missingMethod($parameters = array())
    {
    }

}
