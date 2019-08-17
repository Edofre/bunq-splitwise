@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('bunq.payments') }}</div>

                    <div class="card-body">
                        <ul class="list-group">
                            @forelse($payments as $payment)
                                <?php
                                var_dump($payment);
                                ?>
                            @empty
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ __('bunq.no_payments_found') }}
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
