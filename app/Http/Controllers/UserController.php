<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
class UserController extends Controller
{
    //
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(){
        $keyword = request()->get('keyword');
        if($keyword){
            $users = $this->userService->getUsersWithRolesFilter($keyword);
        }else{
            $users = $this->userService->getUsers(10);

        }
        return view('users.index', [
            'users' => $users
        ]);
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $request->role,
        ]);
        activity('create account')->log(auth()->user()->name . ' created account ' . $user->name);
        return redirect()->route('user.list')->with('status', 'User created successfully!');
    }

    public function update(Request $request, $id)
    {

        $user = User::find($id);
        $user->name = $request->name;
        $user->role = $request->role;
        if($user->email != $request->email) $user->email = $request->email;

        $user->save();
        activity('update account')->log(auth()->user()->name . ' updated ' . $user->name);
        return redirect()->route('user.list')
            ->with('success', 'User updated successfully!');

    }

    public function destroy($id)
    {

        $user = User::findOrFail($id);
        $name = $user->name;
        // Không cho phép xóa tài khoản admin
        if ($user->role === 'admin') {
            return redirect()->route('user.list')
                ->with('error', 'Cannot delete admin account!');
        }
        $user->delete();
        activity('delete account')->log(auth()->user()->name . ' deleted ' . $name);
        return redirect()->route('user.list')
            ->with('success', 'User deleted successfully!');
    }

    public function deleteSelected(Request $request){
        $ids = json_decode($request->selected_ids, true);
        $this->userService->deleteSelectedUser($ids);
        // activity('delete account')->log(auth()->user()->name . ' deleted ' . $name);

        return redirect()->route('user.list')
            ->with('success', 'Users deleted successfully!');
    }

}
