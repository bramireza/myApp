<?php

namespace App\Http\Controllers;

use App\Models\Code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'message' => 'Lista de Codigos!',
            'codes' => Code::all(),
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
            'code' => 'required|string|max:15',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $code = Code::create([
            'code'   => $request['code'],
            'user_id' => auth()->user(),
        ]);

        return response()->json([
            'message' => 'Codigo registrado!',
            'code' => $code
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Code $code)
    {
        return response()->json([
            'message' => '¡Mostrar Codigo!',
            'code' => $code
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Code $code)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:15',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $code->update([
            'code'   => $request['code'],
        ]);

        return response()->json([
            'message' => 'Codigo actualizado!',
            'code' => $code
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Code $code)
    {
        $code->delete();

        return response()->json([
            'message' => 'Codigo eliminado!',
        ]);
    }
}