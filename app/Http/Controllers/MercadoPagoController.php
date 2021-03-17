<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

// Requests
use App\Http\Requests\MercadoPagoRequest;

// Mercado Pago
use MercadoPago\SDK as MercadoPagoSDK;
use MercadoPago\Payment as MercadoPagoPayment;
use MercadoPago\Payer as MercadoPagoPayer;


class MercadoPagoController extends Controller
{
    public function processPayment(MercadoPagoRequest $request)
    {
        MercadoPagoSDK::setAccessToken('TEST-6765632652566384-031220-09d9a467a746d7d9b06febde7e32f41c-249922967');
        
        $payment = new MercadoPagoPayment();
        $payment->transaction_amount = $request->transactionAmount;
        $payment->description = $request->description;
        $payment->payment_method_id = $request->paymentMethodId;

        if($request->paymentMethod == 1) {
            $payment->token = $request->token;
            $payment->installments = $request->installments;
            //$payment->issuer_id = $request->issuer;
        }

        $payer = new MercadoPagoPayer();
        $payer->email = $request->email;
        $payer->first_name = $request->payerFirstName;
        $payer->last_name = $request->payerLastName;
        $payer->identification = array(
            'type' => $request->docType,
            'number' => $request->docNumber
        );
        
        $payment->payer = $payer;
        
        $payment->save();

        $verificaStatus = $this->verificaStatus($payment);
        $response = array('status' => $payment->status, 'status_detail' => $payment->status_detail, 'id' => $payment->id, 'verificaStatus' => $verificaStatus);

        //dd($verificaStatus);
        //echo $payment;
        return redirect()->route('checkout.page')->with([
            'status' => $payment->status,
            'status_detail' => $payment->status_detail,
            'id' => $payment->id,
            'title' => $verificaStatus['title'],
            'message' => $verificaStatus['message'],
            'url' => $verificaStatus['url'],
            'color' => $verificaStatus['color']
        ]);
    }

    public function verificaStatus($payment)
    {
        $title = '';
        $message = '';
        $color = '';
        $url = '';
        switch ($payment->status) {
            case 'approved':
                $title = 'Pronto, seu pagamento foi aprovado!';
                $message = '';
                $color = 'success';
                $url = '';

                break;
            case 'rejected':
                $title = 'Não conseguimos processar seu pagamento.';
                $message = 'Revise os dados do seu cartão e tente novamente.';
                $color = 'danger';
                $url = '';
                
                break;
            case 'in_process':
                $title = 'Estamos processando o pagamento.';
                $message = 'Não se preocupe, em menos de 2 dias úteis informaremos por e-mail se foi creditado. Estamos processando seu pagamento.';
                $color = 'info';
                $url = '';
                
                break;
            case 'pending':
                $title = 'Estamos aguardando o pagamento.';
                $message = 'Realize o pagamento do boleto abaixo.';
                $url = $payment->transaction_details->external_resource_url;
                $color = 'warning';
                
                break;
        }

        $response = array('title' => $title, 'message' => $message, 'color' => $color, 'url' => $url);
        return $response;
    }

    public function checkoutPage()
    {
        if(!session()->exists('status')) {
            return redirect()->route('index.page');
        }
        
        return view('checkout');
    }
}
