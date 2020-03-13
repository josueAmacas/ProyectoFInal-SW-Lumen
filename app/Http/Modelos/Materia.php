<?php

namespace App\Http\Modelos;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

/**
 * Description of Persona
 *
 * @author josuemacas
 */
class Materia extends Model{
    
    protected $table ='modelo_materia';
    
    public $timestamps = false;
}
