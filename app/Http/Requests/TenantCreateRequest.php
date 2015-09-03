<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class TenantCreateRequest extends Request
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
            'company_name' => 'required|alpha|min:4|unique:tenants',
            'subdomain' => 'required|alpha|min:4|unique:tenants',
            'admin_name' => 'alpha|min:4',
            'admin_surname' => 'alpha|min:4',
            'admin_email' => 'email|unique:tenants',
        ];
    }
}
