<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class sitioRequest extends Request
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
            'email' => 'required|unique:users,email',
        ];
    }

    public function messages()
    {
        return [
            'identificacion.required' => 'Se debe ingresar el numero de identificacion del administrador del sitio.',
            'identificacion.numeric' => 'La identificacion del administrador, debe contener solo números.',
            'identificacion.unique' => 'El número de identificacion ingresado, ya se encuentra registrado.',
            'identificacion.min' => 'El número de identificacion debe contener al menos 7 digitos.',


            'nombres.required' => 'Ingresa nombre y apellido del administrador del sitio.',
            'nombres.regex' => 'El nombre no puede contener caracteres numericos.',
            'nombres.max' => 'El nombre y apellido no pueden exceder los 25 caracteres.',

            'telefono.required' => 'Debes ingresar un número movil de contacto con el administrador del sitios!',
            'telefono.numeric' => 'El número movil debe contener solo caracteres numericos.',
            'telefono.min' => 'El número movil debe contener minimo 10 caracteres.',
//
            'user.required' => 'Debes registrar un nombre de usuario para la cuenta del administrador del sitio.',
            'user.regex' => 'El usuario debe estar en formato nombre.apellido, si no esta disponible, intenta ingresando numeros.',
            'user.unique' => 'El nombre de usuario ingresado, ya eta en uso, intenta otra opcion!',
            'user.min' => 'El nombre de usuario debe contener mínimo 8 caracteres',

            'email.required' => 'Ingresa un correo electronico de contacto con el administrador del sitio',
            'email.unique' => 'El correo electronico ingresado, ya esta en uso por otro usuario.'
        ];
    }
}
