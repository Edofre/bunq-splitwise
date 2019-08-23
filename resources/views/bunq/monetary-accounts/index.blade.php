@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('bunq.monetary_accounts') }}</div>

                    <div class="card-body">
                        <ul class="list-group">
                            @forelse($monetaryAccounts as $monetaryAccount)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ route('bunq.monetary-accounts.show', ['monetaryAccountId' => $monetaryAccount->getReferencedObject()->getId()]) }}">
                                        {{ $monetaryAccount->getReferencedObject()->getDescription() }}
                                    </a>
                                    <span class="badge badge-primary badge-pill">
                                        @price($monetaryAccount->getReferencedObject()->getBalance()->getValue())
                                    </span>
                                </li>
                            @empty
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ __('bunq.no_monetary_accounts_found') }}
                                </li>
                            @endforelse
                        </ul>
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
