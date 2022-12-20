<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'message' => 'Lista de Usuarios!',
            'users' => User::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(array_merge(
            $validator->validate(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json([
            'message' => '¡Usuario registrado!',
            'user' => $user
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json([
            'message' => '¡Mostrar Usuario!',
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'dni' => 'numeric',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user->update([
            'name'   => $request['name'],
            'email'       => $request['email'],
            'dni'         => $request['dni'],
        ]);

        return response()->json([
            'message' => '¡Usuario actualizado!',
            'user' => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => '¡Usuario eliminado!',
        ]);
    }

    public function usuariosRegistrados(Request $request){

        $fechaInicio = $request['fechaInicio'];
        $fechaFin = $request['fechaFin'];
        $users = User::withCount(['created_at' => function($query) {
            $query->where('created_at', '>=', $fechaInicio,'and', 'created_at', '<=',$fechaFin );
        }]);
        return $users;
    }
}