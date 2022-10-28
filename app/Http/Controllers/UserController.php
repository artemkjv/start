<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class UserController extends Controller
{

    private UserService $userService;

    public function __construct(
        UserService $userService
    )
    {
        $this->userService = $userService;
    }

    public function index() {
        $users = User::paginated(
            \request()->user(),
            User::PAGINATE,
            \request()->get('email'),
            \request()->get('sort'),
            \request()->get('by')
        );
        return view('user.index', compact('users'));
    }

    public function create() {
        $string = Str::random(30);
        $key = [
            'key' => $string
        ];
        return view('user.create', array("key"=>$key));
    }

    public function store(StoreRequest $request) {
        $payload = $request->validated();
        if($payload['role'] === User::ROLES['pseudo_admin']) {
            $payload['all_users'] = isset($payload['all_users']);
        }
        $payload['password'] = \Hash::make($payload['password']);
        $payload['tg_key'] = Str::random(30);
        $user = User::create($payload);
        $this->userService->handlePagesRelation($payload, $user);
        $this->userService->handleUsersRelation($payload, $user);
        return redirect()->route('user.index');
    }

    public function edit($id) {
        $user = User::getByUserAndId(\request()->user(), $id);
        return view('user.edit', compact('user'));
    }

    public function update(UpdateRequest $request, $id) {
        $payload = $request->validated();
        if($payload['role'] === User::ROLES['pseudo_admin']) {
            $payload['all_users'] = isset($payload['all_users']);
        }
        $user = User::getByUserAndId(\request()->user(), $id);
        $user->detachOldRelations();
        $this->userService->handleNewPassword($payload);
        $user->update($payload);
        $this->userService->handlePagesRelation($payload, $user);
        $this->userService->handleUsersRelation($payload, $user);
        return redirect()->route('user.index');
    }

    public function loginToAdmin() {
        $adminId = \session()->pull('admin_id', 0);
        $user = User::findOrFail($adminId);
        Auth::login($user);
        return to_route('dashboard');
    }

    public function loginAsAdmin($userId) {
        if(\request()->user()->role !== User::ROLES['superuser'] && \request()->user()->role !== User::ROLES['admin'])
            abort(404);
        $currentUserId = \request()->user()->id;
        $user = User::getByUserAndId(\request()->user(), $userId);
        \session()->put('admin_id', $currentUserId);
        Auth::login($user);
        return to_route('dashboard');
    }

    public function delete($id){
        $user = User::getByUserAndId(\request()->user(), $id);
        $user->delete();
        return redirect()->back();
    }

}
