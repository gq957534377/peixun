<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
{
    protected $authorize = true;

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
            case 'alarmMessage':
                return [
                    'client_id'     => 'required|string|max:125',
                    'ip'            => 'required|ip',
                    'type'          => 'required|string|max:64',
                    'event_num'     => 'required|numeric',
                    'hex_data'      => 'required|string|max:255',
                    'serial_number' => 'required|string|max:255',
                    'check_sum'     => 'required|string|max:255',
                ];
            default:
                {
                    return [];
                }
        }
    }
}
