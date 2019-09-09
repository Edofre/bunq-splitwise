@extends('layouts.app')

@section('title')
    {{ __('splitwise.expenses') }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-receipt"></i>
                        {{ __('splitwise.expenses') }}
                    </div>

                    <div class="card-body">
                        <ul class="list-group">

                            @forelse($expenses as $expense)
                                <li class="list-group-item">
                                    <a href="{{ route('splitwise.expenses.show', ['id' => $expense->id]) }}">
                                        #{{ $expense->id }} | {{ $expense->description }} | @price($expense->cost) | {{ $expense->created_at }}
                                    </a>
                                </li>
                            @empty
                                <li class="list-group-item">
                                    {{ __('splitwise.no_expenses_found') }}
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
