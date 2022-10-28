<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Page;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const ROLES = [
        'superuser' => 'SUPERUSER',
        'admin' => 'ADMIN',
        'pseudo_admin' => 'PSEUDO_ADMIN',
        'webmaster' => 'WEBMASTER',
        'partner' => 'PARTNER',
        'new' => 'NEW',
        'blocked' => 'BLOCKED',
    ];

    public const ROLE_PAGE = [
        'pseudo_admin' => 'PSEUDO_ADMIN',
        'webmaster' => 'WEBMASTER',
        'partner' => 'PARTNER',
    ];

    public const PAGINATE = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'telegram',
        'password',
        'role',
        'two_factor_secret',
        'two_factor_recovery_codes'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function pages(){
        switch ($this->role){
            case self::ROLES['superuser']:
            case self::ROLES['admin']:
                return Page::query();
            case self::ROLES['pseudo_admin']:
                return $this->belongsToMany(Page::class, 'user_page');
            case self::ROLES['blocked']:
                return Page::query()
                    ->where('id', 0);
            default:
                return Page::query()
                    ->whereRaw("FIND_IN_SET(\"" . \request()->user()->role . "\", roles)");
        }
    }

    public function users() {
        $relation = $this->belongsToMany(
            self::class,
            'admin_user',
            'admin_id',
            'user_id'
        )
            ->where('role', '!=', self::ROLES['admin'])
            ->where('role', '!=', self::ROLES['superuser'])
            ->where('id', '!=', $this->id);
        return match ($this->role) {
            self::ROLES['admin'], self::ROLES['superuser'] => self::query()
                ->where('id', '!=', $this->id)
                ->where('role', '!=', self::ROLES['superuser']),
            self::ROLES['pseudo_admin'] => $relation,
            default => self::query()
                ->whereNull('id'),
        };
    }

    public static function getByUser(self $user) {
        return $user->users()
            ->get();
    }

    public static function getByEmail($email) {
        return self::query()
            ->where('email', $email)
            ->first();
    }

    public static function getByUserAndId(self $user, int $id){
        return $user->users()
            ->findOrFail($id);
    }

    public static function getByUserAndIds(self $user, $ids) {
        return $user->users()
            ->whereIn('id', $ids)
            ->get();
    }

    public static function paginated(
        User $user,
        $paginate = self::PAGINATE,
        $email = null,
        $sort = null,
        $by = null
    ){
        return $user
            ->users()
            ->when($sort && $by, function ($query) use ($sort, $by){
                $query->orderBy($sort, $by);
            }, function ($query){
                $query->orderByDesc('id');
            })
            ->when($email, function ($query, $email){
                $query->where('email', 'LIKE', "%$email%");
            })
            ->paginate($paginate)
            ->appends(request()->except('page'));
    }

    public function detachOldRelations(){
        $usersRelation = $this->belongsToMany(
            self::class,
            'admin_user',
            'admin_id',
            'user_id'
        );
        $pagesRelation = $this->belongsToMany(Page::class, 'user_page');
        $usersRelation->sync([]);
        $pagesRelation->sync([]);
    }

}
