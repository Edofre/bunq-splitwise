@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('splitwise.friends') }}</div>

                    <div class="card-body">
                        @forelse($friends as $friend)
                            <div class="media">
                                <img src="{{ $friend->picture->medium }}" class="mr-3" alt="{{ $friend->first_name }}">
                                <div class="media-body">
                                    <h5 class="mt-0">
                                        <a href="{{ route('splitwise.friends.show', ['id' => $friend->id]) }}">{{ $friend->email }}</a>
                                    </h5>
                                    @price($friend->balance[0]->amount)
                                </div>
                            </div>
                        @empty
                            {{ __('splitwise.no_friends_found') }}
                        @endforelse
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
