<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMembers extends FormRequest
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
            
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:members,email',
            'address' => 'required',
            'city'  => 'required', 
            'dpt' => 'required',  
            'country' => 'required',  
            'n_doc' => 'required',
            'cc_name' => 'required|string',
            'cc_number' => 'required|string|min:16|max:20',
            'cc_expiration' => 'required|string|min:5',
            'cc_cvv' => 'required|string|min:3',
           
        ];
    }
}
