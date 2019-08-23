@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <i class="fas fa-money-bill-wave"></i>
                                {{ __('bunq.payment') }}
                            </div>
                            <div class="col-md-6">
                                {{-- Buttons :)--}}
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="dl-horizontal">
                                    <dt>{{ __('payment.id') }}</dt>
                                    <dd>{{ $payment->id }}</dd>

                                    <dt>{{ __('payment.bunq_payment_id') }}</dt>
                                    <dd>{{ $payment->bunq_payment_id }}</dd>

                                    <dt>{{ __('payment.bunq_monetary_account_id') }}</dt>
                                    <dd>{{ $payment->bunq_monetary_account_id }}</dd>

                                    <dt>{{ __('payment.splitwise_id') }}</dt>
                                    <dd>{{ $payment->splitwise_id }}</dd>

                                    <dt>{{ __('payment.type') }}</dt>
                                    <dd>{{ $payment->type }}</dd>

                                    <dt>{{ __('payment.sub_type') }}</dt>
                                    <dd>{{ $payment->sub_type }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="dl-horizontal">
                                    <dt>{{ __('payment.value') }}</dt>
                                    <dd>{{ $payment->value }}</dd>

                                    <dt>{{ __('payment.currency') }}</dt>
                                    <dd>{{ $payment->currency }}</dd>

                                    <dt>{{ __('payment.description') }}</dt>
                                    <dd>{{ $payment->description }}</dd>

                                    <dt>{{ __('payment.payment_at') }}</dt>
                                    <dd>{{ $payment->payment_at }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        // Scripts :)
    </script>
@endpush
