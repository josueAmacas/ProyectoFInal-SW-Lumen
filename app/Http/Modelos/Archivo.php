<?php

namespace App\Http\Modelos;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use App\Http\Modelos\Tramite;

/**
 * Description of Persona
 *
 * @author josuemacas
 */
class Archivo extends Model{
    
    protected $table ='modelo_archivo';
    
    public $timestamps = false;
    
}