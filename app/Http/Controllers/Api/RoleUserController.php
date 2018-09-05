<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleUserController extends Controller
{
    public function index(Request $request)
    {
        $roleId = $request->get('q');
        $users = array();
        if ($roleId)
        {
            $users = Role::find($roleId)->user()->get(['id','name as text']);
        }
        return $users;

    }
}
