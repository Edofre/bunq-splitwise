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
                                {{ __('bunq.payments') }}
                            </div>
                            <div class="col-md-6">
                                <div class="float-right">
                                    <a class="btn btn-sm btn-primary" href="{{ route('bunq.payments.index') }}">
                                        <i class="fas fa-list"></i>
                                        {{ __('bunq.show_all_payments') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('bunq.payments.filter') }}" method="GET" class="form-inline">
                            <label class="mr-3">{{ __('payment.filter') }}</label>

                            <label class="sr-only" for="month">{{ __('payment.filter_month') }}</label>
                            <select name="month" id="month" class="custom-select custom-control-inline">
                                @foreach(range(1, 12) as $monthOption)
                                    <option {{ ($monthOption == $month) ? 'selected' : null }} value="{{ $monthOption }}">{{ $monthOption }}</option>
                                @endforeach
                            </select>

                            <label class="sr-only" for="year">{{ __('payment.filter_year') }}</label>
                            <select name="year" id="year" class="custom-select custom-control-inline">
                                @foreach(range(2012, 2030) as $yearOption)
                                    <option {{ ($yearOption == $year) ? 'selected' : null }} value="{{ $yearOption }}">{{ $yearOption }}</option>
                                @endforeach
                            </select>

                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>


                        <?php var_dump($payments) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">

    </script>
@endpush
