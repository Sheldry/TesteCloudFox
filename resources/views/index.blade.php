@extends('layouts.master')

@section('page-title', 'Processar Pagamentos')
@section('page-content')
    
    <div class="container py-4">
        
        <!-- ALERT ERROR -->
        @if($errors->all())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- END ALERT ERROR -->
        
        <!-- FORM MERCADO PAGO -->
        <form action="{{ route('process-payment') }}" method="post" id="paymentForm">
            @csrf
        
            <div class="card mb-4">
                <h3 class="card-header">Forma de Pagamento</h3>
                <div class="card-body">
                    <div>
                        <select class="custom-select" id="paymentMethod" name="paymentMethod">
                            <option value="">Selecione uma forma de pagamento</option>
                            <option value="1">Cartão de crédito</option>
                            <option value="2">Boleto</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <h3 class="card-header">Detalhe do comprador</h3>
                <div class="card-body">
                    <div>
                        <div class="form-group">
                            <label for="payerFirstName" class="m-0">Nome</label>
                            <input id="payerFirstName" name="payerFirstName" type="text" class="form-control" value="Nome"></select>
                        </div>

                        <div class="form-group">
                            <label for="payerLastName" class="m-0">Sobrenome</label>
                            <input id="payerLastName" name="payerLastName" type="text" class="form-control" value="Sobrenome"></select>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="m-0">E-mail</label>
                            <input id="email" name="email" type="text" class="form-control" value="test@test.com"/>
                        </div>
                        
                        <div class="form-group">
                            <label for="docType" class="m-0">Tipo de documento</label>
                            <select id="docType" name="docType" data-checkout="docType" type="text" class="custom-select"></select>
                        </div>
                        
                        <div class="form-group">
                            <label for="docNumber" class="m-0">Número do documento</label>
                            <input id="docNumber" name="docNumber" data-checkout="docNumber" type="text" class="form-control" value="00000000000" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4" id="detalheCartao">
                <h3 class="card-header">Detalhe do cartão</h3>
                <div class="card-body">
                    <div>
                        <div class="form-group">
                            <label for="cardholderName" class="m-0">Titular do cartão</label>
                            <input id="cardholderName" data-checkout="cardholderName" type="text" class="form-control">
                        </div>
                    
                        <div class="form-group">
                            <label for="cardNumber" class="m-0">Número do cartão</label>
                            <input class="form-control" type="text" id="cardNumber" data-checkout="cardNumber">
                        </div>
                        
                        <div class="form-group">
                            <label for="" class="m-0">Data de vencimento</label>
                            <div class="form-row">
                                <div class="col-6">
                                    <input class="form-control" type="text" placeholder="MM" id="cardExpirationMonth" data-checkout="cardExpirationMonth">
                                </div>
                                <div class="col-6">
                                    <input class="form-control" type="text" placeholder="AA" id="cardExpirationYear" data-checkout="cardExpirationYear">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="securityCode" class="m-0">Código de segurança</label>
                            <input class="form-control" id="securityCode" data-checkout="securityCode" type="text" onselectstart="return false" onpaste="return false" oncopy="return false" oncut="return false" ondrag="return false" ondrop="return false" autocomplete=off>
                        </div>

                        <div class="form-group" id="issuerInput">
                            <label for="issuer" class="m-0">Banco emissor</label>
                            <select id="issuer" name="issuer" data-checkout="issuer" class="custom-select"></select>
                        </div>
                        
                        <div class="form-group">
                            <label for="installments" class="m-0">Parcelas</label>
                            <select type="text" id="installments" name="installments" class="custom-select"></select>
                        </div>
                        
                        <div>
                            <input type="hidden" name="transactionAmount" id="transactionAmount" value="100" />
                            <input type="hidden" name="paymentMethodId" id="paymentMethodId" />
                            <input type="hidden" name="description" id="description" value="Teste integração Mercado Pago" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-success">Finalizar pagamento</button>
            </div>
        </form>
        <!-- END FORM MERCADO PAGO -->

    </div>

@endsection

@section('scripts')
    <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
    <script src="{{ url(mix('assets/js/scripts.js')) }}"></script>
@endsection