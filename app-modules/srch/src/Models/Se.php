<?php

namespace Modules\Srch\Models;

class Se extends \BaseModel
{
    protected $table = 'srch_se';

    public function items()
    {
        return $this->hasMany('Modules\Srch\Models\SeItem');
    }

    public function top_items()
    {
        return $this->hasMany('Modules\Srch\Models\SeItem')
                    ->where('parent_id', 0)->where('is_show', 1)
                    ->orderBy('sort_order')->orderBy('id');
    }
}
