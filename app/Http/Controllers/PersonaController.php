<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

/**
 * Description of PersonaController
 *
 * @author josuemacas
 */
use App\Http\Helper\ResponseBuilder;
use Illuminate\Http\Request;
use App\Http\Modelos\Persona;
use App\Http\Modelos\Docente;
use App\Http\Modelos\Tramite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Hashing\BcryptHasher;
use App\Http\Modelos\Seguimiento;
use Laravel\Lumen\Routing\Controller as Controller;
use DB;

class PersonaController extends Controller {

    public function __construct() {
        
    }

    //Conseguir lista de todos los usuarios
    public function listaUsuarios(Request $request) {
        $status = true;
        $info = "Data is listed succesfully";
        $lista = Persona::all();
        return ResponseBuilder::result($status, $info, $lista);
    }
    
    //Conseguir Persona por cedula
    public function getPersona(Request $request, $cedula) {
        $persona = Persona::where('cedula', $cedula)->get();
        if (!$persona->isEmpty()) {
            $status = true;
            $info = "Data is listed succesfully";
        } else {
            $status = false;
            $info = "Data is not listed succesfully";
        }
        return ResponseBuilder::result($status, $info, $persona);
    }

    //Conseguir lista de todos los Docentes
    public function listaDocentes(Request $recuest) {
        $status = true;
        $info = "Data is listed succesfully";
        $listaDocentes = DB::select("select * from modelo_docente inner join modelo_persona on modelo_docente.persona_id = modelo_persona.persona_id");
        return ResponseBuilder::result($status, $info, $listaDocentes);
    }

    //Conseguir Docente por cedula
    public function getDocente(Request $request, $cedula) {
        $docente = DB::select("select * from modelo_docente inner join modelo_persona on modelo_docente.persona_id=modelo_persona.persona_id "
                        . "where modelo_persona.persona_id=(select persona_id from modelo_persona where cedula=" . $cedula . ")");

        if ($docente) {
            $status = true;
            $info = "Data is listed succesfully";
        } else {
            $status = false;
            $info = "Data is not listed succesfully";
        }
        return ResponseBuilder::result($status, $info, $docente);
    }

    //COnseguir lista de todos los tramites
    public function getTramites(Request $request) {
        $tramite = DB::select('select * from modelo_tramite inner join modelo_persona on modelo_tramite.persona_id = modelo_persona.persona_id');
        if ($tramite) {
            $status = true;
            $info = "Data is listed succesfully";
        } else {
            $status = false;
            $info = "Data is not listed succesfully";
        }
        return ResponseBuilder::result($status, $info, $tramite);
    }
    
    //Conseguir lista de todos los Tramites de un estudiante mediante su cedula
    public function getTramiteEstudiante(Request $request, $cedula) {
        $tramite = DB::select("select * from modelo_tramite inner join modelo_persona on modelo_tramite.persona_id=modelo_persona.persona_id "
                        . "where modelo_persona.persona_id=(select persona_id from modelo_persona where cedula=" . $cedula . ")");
        if ($tramite) {
            $status = true;
            $info = "Data is listed succesfully";
        } else {
            $status = false;
            $info = "Data is not listed succesfully";
        }
        return ResponseBuilder::result($status, $info, $tramite);
    }

    public function getTramiteCodigo(Request $request, $id) {
        $tramite = DB::select('select * from modelo_tramite inner join modelo_persona on modelo_tramite.persona_id=modelo_persona.persona_id '
                . 'where modelo_tramite.tramite_id='.$id);
        if ($tramite) {
            $status = true;
            $info = "Data is listed succesfully";
        } else {
            $status = false;
            $info = "Data is not listed succesfully";
        }
        return ResponseBuilder::result($status, $info, $tramite);
    }

    public function crearPersona(Request $request) {
        $persona = new Persona();
        $persona->password = Hash::make($request->password, ['rounds' => 15]);
        $persona->is_superuser = TRUE;
        $persona->username = $request->username;
        $persona->first_name = $request->first_name;
        $persona->last_name = $request->last_name;
        $persona->email = $request->email;
        $persona->is_staff = TRUE;
        $persona->is_active = TRUE;
        $persona->date_joined = '2020-03-06 10:39:00';
        $persona->cedula = $request->cedula;
        $persona->edad = $request->edad;
        $persona->fechaNacimiento = $request->fechaNacimiento;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->foto = 'gallery/sin_foto.jpg';
        $persona->isDecano = FALSE;
        $persona->isDocente = FALSE;
        $persona->isAbogado = FALSE;
        $persona->isEstudiante = TRUE;
        $persona->rol_id = 4;
        $persona->save();
        $status = false;
        $info = "Data is not listed succesfully";

        return ResponseBuilder::result($status, $info, $persona);
    }

    public function ModificarPersona(Request $request, $cedula) {

        if ($request->isJson()) {
            $persona = DB:: select("select * from modelo_persona where cedula=" . $cedula);
            //print($persona);
            if ($persona != null) {
                $status = true;
                $info = "Data is listed succesfully";

                $persona->first_name = $request->first_name;
                $persona->last_name = $request->last_name;
                $persona->edad = $request->edad;
                $persona->fechaNacimiento = $request->fechaNacimiento;
                $persona->direccion = $request->direccion;
                $persona->telefono = $request->telefono;
                $persona->save();
            } else {
                $status = false;
                $info = "Data is not listed succesfully";
            }
            return ResponseBuilder::result($status, $info, $persona);
        } else {
            $status = false;
            $info = "Unauthorized";
            return ResponseBuilder::result($status, $info);
        }
    }

}
