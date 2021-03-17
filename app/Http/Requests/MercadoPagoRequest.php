<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MercadoPagoRequest extends FormRequest
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
            'paymentMethod' => 'required',
            'transactionAmount' => 'required',
            'token' => ($this->request->all()['paymentMethod'] == 1 ? 'required' : ''),
            'installments' => ($this->request->all()['paymentMethod'] == 1 ? 'required|integer' : ''),
            'paymentMethodId' => ($this->request->all()['paymentMethod'] == 1 ? 'required' : ''),
            'issuer' => ($this->request->all()['paymentMethod'] == 1 ? 'required|integer' : ''),
            'email' => 'required',
            'docType' => 'required',
            'docNumber' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'paymentMethod.required' => 'A forma de pagamento é obrigatória',
            'transactionAmount.required' => 'Erro ao processar valor da compra, tente novamente mais tarde',
            'token.required' => 'Erro ao enviar token, tente novamente mais tarde',
            'installments.required' => 'O número de parcelas é obrigatório ',
            'paymentMethodId.required' => 'Erro ao processar método de pagamento, tente novamente mais tarde',
            'issuer.required' => 'O banco emissor é obrigatório',
            'email.required' => 'O email é obrigatório',
            'docType.required' => 'O tipo de documento é obrigatório',
            'docNumber.required' => 'O número do documento é obrigatório'
        ];
    }
}
