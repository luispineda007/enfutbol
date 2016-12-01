<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class userRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'identificacion' => 'required|numeric|unique:personas,identificacion|min:7',
            'nombres'=> 'required|regex:/[A-ZñÑa-z ]*/|max:25',
            'telefono' => 'required|numeric|min:10',
//
            'user' => 'required|regex:/([A-Za-z])+\.([A-Za-z])+/|unique:users,user|min:8',
            'contrasena' => 'required|min:6|max:20',
            'email' => 'required|unique:users,email',
        ];
    }

    public function messages()
    {
        return [
            'identificacion.required' => 'Ingresa un número de identificacion, para poder registrarte.',
            'identificacion.numeric' => 'La identificacion debe contener solo números.',
            'identificacion.unique' => 'El número de identificacion ya se encuentra registrado.',
            'identificacion.min' => 'El número de identificacion debe contener al menos 7 digitos.',


            'nombres.required' => 'Ingresa nombre y apellido para poder registrarte.',
            'nombres.regex' => 'El nombre no puede contener caracteres numericos.',
            'nombres.max' => 'El nombre y apellido no pueden exceder los 25 caracteres.',

            'telefono.required' => 'Debes ingresar un número movil de contacto para las reservas!',
            'telefono.numeric' => 'El número de telefono debe contener solo caracteres numericos.',
            'telefono.min' => 'El número movil debe contener minimo 10 caracteres.',
//
            'user.required' => 'Debes registrar un nombre de usuario con el cual iniciar sesion.',
            'user.regex' => 'El usuario debe estar en formato nombre.apellido, si ya intentaste esto y no esta disponible, intenta ingresando numeros al final.',
            'user.unique' => 'El nombre de usuario ingresado, ya eta en uso, intenta otra opcion!.',
            'user.min' => 'El nombre de usuario debe contener minomo 8 caracteres',

            'contrasena.required' => 'Debes ingresar una contraseña para iniciar sesion',
            'contrasena.min' => 'La contraseña debe contener minimo 6 caracteres.',
            'contrasena.max' => 'La contraseña debe contener maximo 20 caracteres.',

            'email.required' => 'Ingresa tu correo electronico de contacto!',
            'email.unique' => 'El correo electronico ingresado, ya esta en uso por otro usuario.'
        ];
    }
}


