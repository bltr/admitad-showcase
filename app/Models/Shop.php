<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    public const IMPORT_GROUP_BY_GROUP_ID = 'import_group_by_group_id';
    public const IMPORT_GROUP_BY_PICTURE = 'import_group_by_picture';
    public const IMPORT_GROUP_BY_URL = 'import_group_by_url';

}
