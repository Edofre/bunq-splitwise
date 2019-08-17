@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">

                        <div class="row">
                            <div class="col-md-6">
                                {{ __('bunq.monetary_account') }}
                            </div>
                            <div class="col-md-6">
                                <div class="float-right">
                                    <a class="btn btn-sm btn-primary" href="{{ route('bunq.monetary-accounts.payments.sync', ['monetaryAccountId' => $monetaryAccount->getReferencedObject()->getId()]) }}" onclick="event.preventDefault(); document.getElementById('payments-sync-form').submit();">
                                        <i class="fas fa-sync"></i>
                                        {{ __('bunq.sync') }}
                                    </a>
                                    <form id="payments-sync-form" action="{{ route('bunq.monetary-accounts.payments.sync', ['monetaryAccountId' => $monetaryAccount->getReferencedObject()->getId()]) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <?php

                        var_dump($monetaryAccount);

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        // Do things
    </script>
@endpush
