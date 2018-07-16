<?php

namespace App\Http\Requests;

use App\VitalGym\Entities\Membership;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMembershipFormRequest extends FormRequest
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
            'date_start' => 'required|date|after_or_equal:today',
            'date_end' => 'required|date|after_or_equal:date_start',
            'total_days' => optional(Membership::findOrFail($this->route('membershipId')))->plan->is_premium
                            ? 'required|integer|min:1'
                            : '',
            'customer_id' => 'required|exists:customers,id',
            'membership_quantity' => 'required|integer|min:1',
        ];
    }
}
