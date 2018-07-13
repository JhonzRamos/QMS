<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRisksRequest extends FormRequest {

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
            'riskcategory_id' => 'required', 
            'sRiskName' => 'required', 
            'sConsequence' => 'required', 
            'sPotentialCause' => 'required', 
            
		];
	}
}
