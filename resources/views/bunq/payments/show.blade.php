@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
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
                                    <dt>{{ __('monetary-account.id') }}</dt>
                                    <dd>{{ $monetaryAccount->getReferencedObject()->getId() }}</dd>

                                    <dt>{{ __('monetary-account.description') }}</dt>
                                    <dd>{{ $monetaryAccount->getReferencedObject()->getDescription() }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="dl-horizontal">
                                    <dt>{{ __('monetary-account.created_at') }}</dt>
                                    <dd>{{ $monetaryAccount->getReferencedObject()->getCreated() }}</dd>

                                    <dt>{{ __('monetary-account.updated_at') }}</dt>
                                    <dd>{{ $monetaryAccount->getReferencedObject()->getUpdated() }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                {{ __('bunq.payments') }}
                            </div>
                            <div class="col-md-6">
                                <div class="float-right">
                                    <a href="#" data-refresh-datatable title="{{ __('common.refresh_data') }}" class='btn btn-sm btn-primary'>
                                        <span class="icon"><i class="fa fa-redo-alt"></i></span>
                                        {{ __('common.refresh_data') }}
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
                                    <th scope="col">{{ __('payment.description') }}</th>
                                    <th scope="col">{{ __('payment.value') }}</th>
                                    <th scope="col">{{ __('payment.payment_at') }}</th>
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
                url: '{{ route('bunq.monetary-accounts.payments.data', ['monetaryAccountId' => $monetaryAccountId]) }}',
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'description', name: 'description'},
                {data: 'value', name: 'value'},
                {data: 'payment_at', name: 'payment_at'},
            ]
        });

        $('[data-refresh-datatable]').on('click', function () {
            paymentsDatatable.draw();
        })
    </script>
@endpush
