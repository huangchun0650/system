<?php

namespace YFDev\System\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Menu extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const FIELDS = [
        'name',
        'code',
        'sort_order' => 'sortOrder',
        'parent_id'  => 'parentId',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'menu_has_permissions', 'menu_id', 'permission_id');
    }

    public function rules()
    {
        return $this->belongsToMany(Rule::class, 'menu_has_rules', 'menu_id', 'rule_id');
    }
}
