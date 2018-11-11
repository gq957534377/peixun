<?php

namespace App\Http\Requests\Web;

use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{

    private $authorize = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->authorize;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->route()->getActionMethod()) {
            case 'store':
                $this->authorize = in_array(Auth::user()->role, [User::Role_Admin, User::Role_School, User::Role_Educator, User::Role_Laboratory]);
                return $this->store();
            case 'update':
                return $this->update();
            case 'resetPwd':
                return ['password' => 'required|min:6'];
            default:
                {
                    return [];
                }
        }
    }

    public function messages()
    {
        return [
            'email.not_in'=>'该邮箱已被注册，请更换邮箱'
        ];
    }

    private function store()
    {
        $rules = [
            'name' => 'required|max:128',
            'email' => [
                'required',
                'email',
                Rule::notIn(User::get()->pluck('email')->toArray())
            ],
            'password' => 'required|min:6',
            'tel' => 'required|min:11|max:11',
            'head_img' => 'nullable',
        ];

        switch (Auth::user()->role) {
            case User::Role_Admin :
                $rules['role'] = ['required', Rule::in([User::Role_Educator, User::Role_School, User::Role_Laboratory, User::Role_Teacher])];
                break;
            case User::Role_Educator :
                $rules['role'] = ['required', Rule::in([User::Role_School])];
                break;
            case User::Role_School :
                $rules['role'] = ['required', Rule::in([User::Role_Security, User::Role_Laboratory, User::Role_Teacher])];
                $rules['school_id'] = ['required', Rule::in(Auth::user()->schools->pluck('id')->toArray())];
                break;
            default:
                break;
        }
        return $rules;
    }

    private function update()
    {
        $rules = $this->store();
        unset($rules['password']);
        $rules['email'] = [
            'required',
            'email',
            Rule::notIn(User::where('id', '!=', explode('/', $this->path())[1])->get()->pluck('email')->toArray())
        ];
        if (Auth::user()->id == explode('/', $this->path())[1]) {
            unset($rules['laboratories']);
            unset($rules['role']);
            unset($rules['school_id']);
        }
        return $rules;
    }
}
