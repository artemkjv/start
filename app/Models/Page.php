<?php

namespace App\Models;

use App\Casts\AsSet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Page extends Model
{
    use HasFactory;

    public $timestamps = false;
    public const PAGINATE = 10;

    protected $fillable = [
        'name',
        'route',
        'is_visible',
        'icon',
        'roles',
        'page_group_id'
    ];

    public $casts = [
        'roles' => AsSet::class
    ];

    public static function getByUserAndId(User $user, $id) {
        return $user
            ->pages()
            ->findOrFail($id);
    }

    public static function getByUserAndRoute(User $user, $route) {
        if($user->role === User::ROLES['pseudo_admin']) {
            try {
                return self::getPageByRoleAndRoute($user->role, $route);
            } catch (ModelNotFoundException $e) {}
        }
        return $user
            ->pages()
            ->where('route', $route)
            ->firstOrFail();
    }


    public static function getByUser(User $user) {
        return $user
            ->pages()
            ->get();
    }

    public static function getByUserAndVisibility(User $user, bool $isVisible) {
        $relatedPages = $user
            ->pages()
            ->with('group')
            ->where('is_visible', $isVisible)
            ->get();
        if($user->role === User::ROLES['pseudo_admin']) {
            $rolePages = self::getPagesByRole($user->role);
            $relatedPages = $relatedPages->merge($rolePages);
        }
        return $relatedPages;
    }

    public static function getPagesByRole(string $role) {
        return Page::query()
            ->with('group')
            ->where('is_visible', true)
            ->whereRaw("FIND_IN_SET(\"" . $role . "\", roles)")
            ->get();
    }

    public static function getPageByRoleAndRoute(string $role, string $route) {
        return Page::query()
            ->whereRaw("FIND_IN_SET(\"" . $role . "\", roles)")
            ->where('route', $route)
            ->firstOrFail();
    }

    public static function paginated(
        User $user,
        $paginate = self::PAGINATE,
        $sort = null,
        $by = null
    ){
        return $user
            ->pages()
            ->when($sort && $by, function ($query) use ($sort, $by){
                $query->orderBy($sort, $by);
            }, function ($query){
                $query->orderByDesc('id');
            })
            ->paginate($paginate)
            ->appends(request()->except('page'));
    }

    public function group() {
        return $this->belongsTo(PageGroup::class, 'page_group_id', 'id');
    }

}
