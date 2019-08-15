@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('splitwise.friends') }}</div>

                    <div class="card-body">
                        @foreach($friends as $friend)
                            <div class="media">
                                <img src="{{ $friend->picture->medium }}" class="mr-3" alt="{{ $friend->first_name }}">
                                <div class="media-body">
                                    <h5 class="mt-0">
                                        <a href="">{{ $friend->email }}</a>
                                    </h5>
                                    @price($friend->balance[0]->amount)
                                </div>
                            </div>
                        @endforeach
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
