<?php

namespace App\Http\Modelos;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use App\Http\Modelos\Persona;

/**
 * Description of Persona
 *
 * @author josuemacas
 */
class Docente extends Model{
    
    protected $table ='modelo_docente';
    
    public $timestamps = false;
    
    public function docente(){
        return $this->belongsTo('App\Http\Modelos\Persona','persona_id');
    }
}
