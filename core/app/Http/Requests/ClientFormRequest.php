<?php

namespace App\Http\Requests;
class ClientFormRequest extends BaseRequest {
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
        $rules =
            [   'client_no' => 'required|unique:clients,client_no',
                'name'    => 'required|unique:clients,name',
                'email'    => 'required|email|unique:clients,email',
                'address1' => 'required',
                'password' => 'confirmed|min:6',
            ];

        if($id = $this->client)
        {
            $rules['client_no'] .= ','.$id.',uuid';
            $rules['name'] .= ','.$id.',uuid';
            $rules['email'] .= ','.$id.',uuid';
        }else{
            $rules['password'] .= '|required';
        }
        return $rules;
	}

}
