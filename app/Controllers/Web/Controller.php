<?php

namespace app\Controllers\Web;

use App\Traits\CsrfTrait;
use App\Traits\EncodeTrait;
use App\Traits\RequestTrait;
use App\Traits\ResponseTrait;
use App\Traits\SessionTrait;

class Controller
{

    use ResponseTrait, RequestTrait, SessionTrait, EncodeTrait, CsrfTrait;

    public function __construct() {
        /**
         * Gera o Token caso ele não exista
         */
        if (empty($this->session('csrf_token'))) {
            $this->renewCsrfToken();
        }
    }



}