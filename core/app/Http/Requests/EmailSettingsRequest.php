<?php

namespace App\Http\Requests;

class EmailSettingsRequest extends BaseRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
			'protocol'      => 'required',
			'from_email'   	=> 'required',
			'from_name'   	=> 'required',
		];
		return $rules;
	}

}
