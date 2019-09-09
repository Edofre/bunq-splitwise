@extends('layouts.app')

@section('title')
    {{ __('bunq.payments') }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <i class="fas fa-money-bill-wave"></i>
                                {{ __('bunq.payments') }}
                            </div>
                            <div class="col-md-6">
                                <div class="float-right">
                                    <a class="btn btn-sm btn-primary" href="{{ route('bunq.payments.filter') }}">
                                        <i class="fas fa-filter"></i>
                                        {{ __('bunq.filter_payments') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table data-datatable="payments" class="table table-bordered table-sm" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th scope="col">{{ __('payment.id') }}</th>
                                    <th scope="col">{{ __('payment.counterparty_alias') }}</th>
                                    <th scope="col">{{ __('payment.description') }}</th>
                                    <th scope="col">{{ __('payment.value') }}</th>
                                    <th scope="col">{{ __('payment.payment_at') }}</th>
                                    <th scope="col">&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        let paymentsDatatable = $('[data-datatable="payments"]').DataTable({
            ajax: {
                // TODO implement ziggy
                url: '{{ route('bunq.payments.data') }}',
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'counterparty_alias', name: 'counterparty_alias'},
                {data: 'description', name: 'description'},
                {data: 'value', name: 'value'},
                {data: 'payment_at', name: 'payment_at'},
                {data: 'action', name: 'action', searchable: false, orderable: false}
            ]
        });
    </script>
@endpush
