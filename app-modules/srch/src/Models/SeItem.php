<?php

namespace Modules\Srch\Models;

class SeItem extends \BaseModel
{
    protected $table = 'srch_se_item';

    public function children()
    {
        return $this->hasMany('Modules\Srch\Models\SeItem', 'parent_id')
                    ->orderBy('sort_order');
    }
}
