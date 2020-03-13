<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

/**
 * Description of LoginController
 *
 * @author josuemacas
 */
use App\Http\Modelos\Persona;
use App\Http\Helper\ResponseBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Hashing\BcryptHasher;

class LoginController extends Controller {

    public function login(Request $request) {
        $username = $request->email;
        $password = $request->password;

        $user = Persona::where('email', $username)->first();
        if ($user) {
            $status = true;
            $info = "Usuario valido";

            if ($this->django_password_verify($password, $user->password)) {
                $status = true;
                $info = "Usuario correcto";
                return ResponseBuilder::result($status, $info,$user);
            } else {
                $status = false;
                $info = "Usuario incorrecto";
                return ResponseBuilder::result($status, $info);
            }

            return ResponseBuilder::result($status, $info);
        } else {
            $status = false;
            $info = "Usuario no existe";
            return ResponseBuilder::result($status, $info);
        }
        return ResponseBuilder::result($status, $info);
    }

    public function django_password_verify(string $password, string $djangoHash): bool {
        $pieces = explode('$', $djangoHash);
        if (count($pieces) !== 4) {
            throw new Exception("Ilegal Hash format");
        }
        list($header, $iter, $salt, $hash) = $pieces;
        //Get the hash algotithm used:
        if (preg_match('#^pbkdf2_([a-z0-9A-Z]+)$#', $header, $m)) {
            $algo = $m[1];
        } else {
            throw new Exception(sprintf("Bad header (%s)", $header));
        }

        if (!in_array($algo, hash_algos())) {
            throw new Exception(sprintf("Ilegal hash algotihm (%s)", $algo));
        }

        //Has_pbkdf2 = gnera uan derivacion de clave PBKDF2 de una contrasenia proporcionaa
        //algo = es el nombre del algoritmo hash seleccionado
        //salt = es una valor para la derivacion, este valor deberia ser generado aleatoriamente
        $calc = hash_pbkdf2(
                $algo,
                $password,
                $salt,
                (int) $iter,
                32,
                true
        );
        return hash_equals($calc, base64_decode($hash));
    }

}
