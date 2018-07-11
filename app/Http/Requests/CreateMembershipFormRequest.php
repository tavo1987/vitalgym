<?php

namespace App\Http\Requests;

use App\VitalGym\Entities\MembershipType;
use Illuminate\Foundation\Http\FormRequest;

class CreateMembershipFormRequest extends FormRequest
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
            'date_start'          => 'required|date|date_format:Y-m-d|after_or_equal:today',
            'date_end'            => 'required|date|date_format:Y-m-d|after_or_equal:date_start',
            'membership_type_id'  => 'required|exists:membership_types,id',
            'total_days'          => optional(MembershipType::find(request('membership_type_id')))->is_premium
                                     ? 'required|integer|min:1'
                                     : '',
            'customer_id'         => 'required|exists:customers,id',
            'membership_quantity' => 'required|integer|min:1',
        ];
    }
}
