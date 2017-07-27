<?php

namespace Modules\Srch\Logics\User\Se;

use Modules\Srch\Models;
use Exception;
use Request;

class GetIndex extends \BaseLogic
{
    protected function execute()
    {
        try {

            $this->validate();

            $this->getSe();

            $this->result['result'] = true;

        } catch (Exception $e) {
            $this->result['result']  = false;
            $this->result['message'] = $e->getMessage();
        }
    }

    protected function validate ()
    {
        //
    }

    protected function getSe()
    {
        $this->result['se_list'] = Models\Se::orderBy('id', 'desc')->paginate(10);
    }
}
