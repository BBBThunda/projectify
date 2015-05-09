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

//        $sequences = $_POST['sequences'];

        $sequences = [
            41 => ["sequence"=>"1","projectID"=>"41"],
            42 => ["sequence"=>"2","projectID"=>"42"],
            43 => ["sequence"=>"3","projectID"=>"43"],
            44 => ["sequence"=>"4","projectID"=>"44"],
            45 => ["sequence"=>"5","projectID"=>"45"],
            46 => ["sequence"=>"6","projectID"=>"46"],
            47 => ["sequence"=>"8","projectID"=>"47"],
            48 => ["sequence"=>"9","projectID"=>"48"],
            49 => ["sequence"=>"10","projectID"=>"49"],
            50 => ["sequence"=>"11","projectID"=>"50"],
            51 => ["sequence"=>"12","projectID"=>"51"],
            52 => ["sequence"=>"13","projectID"=>"52"],
            53 => ["sequence"=>"14","projectID"=>"53"],
            54 => ["sequence"=>"15","projectID"=>"54"],
            55 => ["sequence"=>"16","projectID"=>"55"]
            ];

        //        $response = new Lib\Result(true,'');
        //        $response->data = $sequences;

        $response = Project::resequence($sequences);

        return Response::json($response);

    }

}
