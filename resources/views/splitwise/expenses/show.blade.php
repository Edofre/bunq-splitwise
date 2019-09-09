@extends('layouts.app')

@section('title')
    {{ $expense->description }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-receipt"></i>
                        {{ $expense->description }}
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="dl-horizontal">
                                    <dt>{{ __('expense.id') }}</dt>
                                    <dd>{{ $expense->id }}</dd>

                                    <dt>{{ __('expense.cost') }}</dt>
                                    <dd>{{ $expense->cost }}</dd>

                                    <dt>{{ __('expense.created_at') }}</dt>
                                    <dd>{{ $expense->created_at }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="dl-horizontal">
                                    <dt>{{ __('expense.description') }}</dt>
                                    <dd>{{ $expense->description }}</dd>
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
        // Do things
    </script>
@endpush
