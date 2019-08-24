<div data-payment-id="{{ $payment->id }}" class="list-group-item list-group-item-action">

    <div class="col-md-12">
        <div class="form-inline">
            <label class="my-1 mr-2">{{ __('payment.payment_at') }}:</label>
            <span class="mr-sm-2">
                <strong>{{ $payment->payment_at->format('d-m-Y') }}</strong>
            </span>

            <label class="my-1 mr-2">{{ __('payment.counterparty_alias') }}:</label>
            <span class="mr-sm-2">
                <strong>{{ $payment->counterparty_alias  }}</strong>
            </span>

            <div class="flex-fill text-right">
                <div onclick="removePayment({{ $payment->id }})" class="btn btn-danger">
                    <i class="fas fa-trash-alt"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mt-2">
        <div class="form-inline">
            <label class="my-1 mr-2" for="description">{{ __('payment.description') }}</label>
            <input type="text" class="form-control flex-fill mr-sm-2" name="payments[{{ $payment->id }}][description]" id="description" value="{{ $payment->guessedDescription }}">

            <label class="my-1 mr-2" for="value">{{ __('payment.value') }}</label>
            <input type="text" class="form-control mr-sm-2" name="payments[{{ $payment->id }}][value]" id="value" value="{{ $payment->value }}">
        </div>
    </div>
</div>
