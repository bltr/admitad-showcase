<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use HasFactory;
    use NodeTrait;

    public $guarded = [];

    protected static function booted()
    {
        static::creating(function (self $instance) {
            $instance->slug = Str::slug($instance->name);
        });
    }

    public function delete()
    {
        if ($this->children->isNotEmpty()) {
            throw new \DomainException('Попытка удаления категории с потомками.');
        }
        return parent::delete();
    }
}
