<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageGroup extends Model
{
    use HasFactory;

    public const PAGINATE = 10;

    protected $fillable = [
        'name'
    ];

    public static function getById($id)
    {
        return self::query()
            ->findOrFail($id);
    }

    public function pages() {
        return $this->hasMany(Page::class);
    }

    public static function paginated(
        $paginate = self::PAGINATE,
    ){
        return self::query()
            ->orderByDesc('id')
            ->withCount('pages')
            ->paginate($paginate)
            ->appends(request()->except('page'));
    }

}
