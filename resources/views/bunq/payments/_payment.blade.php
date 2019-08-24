<div class="list-group-item list-group-item-action">
    <div class="col-md-9">
        <label class="sr-only" for="description">{{ __('payment.description') }}</label>
        <input type="text" class="form-control mb-2 mr-sm-2" name="description" id="description" value="{{ $payment->description }}">
    </div>

    <div class="col-md-3">
        <label class="sr-only" for="value">{{ __('payment.value') }}</label>
        <input type="text" class="form-control mb-2 mr-sm-2" name="value" id="value" value="{{ $payment->value }}">
    </div>
</div>
