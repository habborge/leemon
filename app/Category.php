<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    
    protected $table = 'categories';
    protected $dates = ['deleted_at']; //Registramos la nueva columna
    
    protected $fillable = [
        'id', 'codigo','name', 'description', 'status'
    ];

    public function getChildren($data, $line)
    {
        $children = [];
        foreach ($data as $line1) {
            if ($line['id'] == $line1['father_id']) {
                $children = array_merge($children, [ array_merge($line1, ['submenu' => $this->getChildren($data, $line1) ]) ]);
            }
        }
        return $children;
    }
    public function optionsMenu()
    {
        return $this->where('status', 1)
            ->orderby('father_id')
            ->orderby('id', 'asc')
            ->get()
            ->toArray();
    }

    public static function menus()
    {
        $menus = new Category();
        $data = $menus->optionsMenu();
        $menuAll = [];
        foreach ($data as $line) {
            $item = [ array_merge($line, ['submenu' => $menus->getChildren($data, $line) ]) ];
            $menuAll = array_merge($menuAll, $item);
        }
        //dd($menuAll);
        return $menus->menuAll = $menuAll;

    }
}

