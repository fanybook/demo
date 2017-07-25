<?php

namespace Modules\Base\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use CrudTrait;

    protected $table = 'site_setting';
    protected $fillable = ['key', 'value', 'memo'];
}
