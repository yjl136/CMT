<?php

namespace App\Http\Controllers;


use App\Http\Service\Configs;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    //
    public $lang ;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->initLang();
    }

    public function initLang()
    {
        $this->lang = Configs::getLang();
        if (is_null($this->lang)) {
            $this->lang = config('app.locale');
        }
        if(!in_array($this->lang,config('app.suoportlocale'))){
            $this->lang = config('app.locale');
        }
        config(['locale'=>$this->lang]);
    }


}
