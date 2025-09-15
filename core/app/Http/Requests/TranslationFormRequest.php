<?php

namespace App\Http\Requests;

class TranslationFormRequest extends BaseRequest {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$rules = [
				'locale_name'	=> 'required',
				'short_name' 	=> 'required',
				'status'    	=> 'required',
				'image'         => 'image',
			];
		return $rules;
	}
}
