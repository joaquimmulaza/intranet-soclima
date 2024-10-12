<?php

namespace App\Http\Controllers;

use App\Module;
use App\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RoleController extends Controller
{

    /*Annotation: --------------------------------------------------------------
    |1.
    |2.
    |3.
    |4.
    |5.
    |6.
    |7.
    |8.
    |9.
    |10.
    |--------------------------------------------------------------------------*/

    public function index()
    {
        Gate::authorize('app.roles.index', auth::user());
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        Gate::authorize('app.roles.create', auth::user());
        $modules = Module::all();
        return view('roles.create', compact('modules'));
    }

    public function store(Request $request)
    {
        //Gate::authorize('app.roles.create', auth::user());
        $this->validate($request, [
            'name'=> 'required|unique:roles',
            'permissions'=> 'required|array',
            'permissions.*'=> 'integer',
        ]);

        Role::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
        ])->permissions()->sync($request->input('permissions', []));
        notify()->success('Role Successfully Added.', 'Added');
        return redirect()->route('role.index');
    }

    public function edit(Role $role)
    {
        Gate::authorize('app.roles.edit', auth::user());
        $modules = Module::all();
        return view('roles.create', compact('modules', 'role'));
    }

    public function update(Request $request, Role $role)
    {
        Gate::authorize('app.roles.edit', auth::user());
        $role->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        $role->permissions()->sync($request->input('permissions', []));
        notify()->success('Role Successfully Updated.', 'Updated');
        return redirect()->route('role.index');
    }

    public function destroy(Role $role)
    {
        Gate::authorize('app.roles.destroy', auth::user());

        if ($role->deletable) {
            $role->delete();
            notify()->success("Função deletada com sucesso!", "Deleted");
        } else {
            notify()->error("Você não pode deletar está função.", "Error");
        }
        return back();
    }
}
