<?php

namespace App\Http\Controllers;

use App\Http\Requests\datosRequest;
use App\Models\Model\Datos;
use Illuminate\Http\Request;


class pruebaController extends Controller
{



    public function index()
    {
        $datos = Datos::all();
        return view('principal')->with([
            'datos'=>json_encode($datos),
        ]);
    }
    public function store(datosRequest $request)
    {

        $request->validated();
        $data = $request->json()->all();
        $datos = new Datos();
        $datos->email = $data['email'];
        $datos->departamentos =  $data['departamento'];
        $datos->municipios =  $data['municipio'];

        $datos->save();
        return response()->json(['success' => true,'reg'=>$datos], 200);



    }
    public function confirmar()
    {
        return view('confirmar');
    }
    public function eliminar(Request $request){
        $id = $request->registro['id'];
        $datos = Datos::find( $id);
        $datos->delete( );

        return response( )->json( 'ok' );
    }
}
