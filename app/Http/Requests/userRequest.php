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
            'user' => 'required|regex:/([A-Za-z])+\.([A-Za-z])+/|unique:users,user|min:8',
            'contrasena' => 'required|min:6|max:20',
            'email' => 'required|unique:users,email',
        ];
    }

    public function messages()
    {
        return [
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


