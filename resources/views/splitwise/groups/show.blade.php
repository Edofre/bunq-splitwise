@extends('layouts.app')

@section('title')
    {{ $group->name }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-users"></i>
                        {{ $group->name }}
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <dl class="dl-horizontal">
                                    <dt>{{ __('group.id') }}</dt>
                                    <dd>{{ $group->id }}</dd>

                                    <dt>{{ __('group.created_at') }}</dt>
                                    <dd>{{ $group->created_at }}</dd>

                                    <dt>{{ __('group.updated_at') }}</dt>
                                    <dd>{{ $group->updated_at }}</dd>
                                </dl>
                            </div>
{{--                            <div class="col-md-6">--}}
{{--                                <dl class="dl-horizontal">--}}
{{--                                    <dt>{{ __('friend.email') }}</dt>--}}
{{--                                    <dd>{{ $friend->email }}</dd>--}}
{{--                                </dl>--}}
{{--                            </div>--}}
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
