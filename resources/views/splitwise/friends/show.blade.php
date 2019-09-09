@extends('layouts.app')

@section('title')
    {{ $friend->first_name }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-user"></i>
                        {{ $friend->first_name }}
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="dl-horizontal">
                                    <dt>{{ __('friend.id') }}</dt>
                                    <dd>{{ $friend->id }}</dd>

                                    <dt>{{ __('friend.first_name') }}</dt>
                                    <dd>{{ $friend->first_name }}</dd>

                                    <dt>{{ __('friend.last_name') }}</dt>
                                    <dd>{{ $friend->last_name }}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl class="dl-horizontal">
                                    <dt>{{ __('friend.email') }}</dt>
                                    <dd>{{ $friend->email }}</dd>
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
