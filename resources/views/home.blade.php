@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="col-sm-12 row">
                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-header">
                                        <i class="fas fa-piggy-bank"></i>
                                        Bunq
                                    </div>
                                    <div class="card-body">
                                        @if(is_null($bunqToken))
                                            <a href="{{ route('bunq.oauth.authorize') }}" class="btn btn-primary">
                                                <i class="fas fa-piggy-bank"></i>
                                                Authorize bunq
                                            </a>


                                        @else
                                            <div data-bunq-disconnect-button class="btn btn-success">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                                {{ __('bunq.bunq_connected') }}
                                            </div>

                                            <div data-bunq-disconnect-confirm style="display: none;">
                                                <a class="btn btn-danger" href="{{ route('bunq.oauth.disconnect') }}" onclick="event.preventDefault(); document.getElementById('bunq-disconnect-form').submit();">
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                    {{ __('bunq.disconnect_bunq') }}
                                                </a>
                                                <form id="bunq-disconnect-form" action="{{ route('bunq.oauth.disconnect') }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            </div>

                                            <ul class="mt-3">
                                                <li><a href="{{ route('bunq.monetary-accounts.index') }}">{{ __('bunq.monetary_accounts') }}</a></li>
                                                <li><a href="{{ route('bunq.payments.index') }}">{{ __('bunq.payments') }}</a></li>
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="card">
                                    <div class="card-header">
                                        <i class="fas fa-money-check-alt"></i>
                                        Splitwise
                                    </div>
                                    <div class="card-body">
                                        @if(is_null($splitwiseToken))
                                            <a href="{{ route('splitwise.oauth.authorize') }}" class="btn btn-primary">
                                                <i class="fas fa-money-check-alt"></i>
                                                {{ __('splitwise.authorize_splitwise') }}
                                            </a>
                                        @else
                                            <div data-splitwise-disconnect-button class="btn btn-success">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                                {{ __('splitwise.splitwise_connected') }}
                                            </div>

                                            <div data-splitwise-disconnect-confirm style="display: none;">
                                                <a class="btn btn-danger" href="{{ route('splitwise.oauth.disconnect') }}" onclick="event.preventDefault(); document.getElementById('splitwise-disconnect-form').submit();">
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                    {{ __('splitwise.disconnect_splitwise') }}
                                                </a>
                                                <form id="splitwise-disconnect-form" action="{{ route('splitwise.oauth.disconnect') }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            </div>

                                            <ul class="mt-3">
                                                <li><a href="{{ route('splitwise.friends.index') }}">{{ __('splitwise.show_friends') }}</a></li>
                                                <li><a href="{{ route('splitwise.groups.index') }}">{{ __('splitwise.show_groups') }}</a></li>
                                                <li><a href="{{ route('splitwise.users.current') }}">{{ __('splitwise.show_current_user') }}</a></li>
                                            </ul>
                                        @endif
                                    </div>
                                </div>

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
        $("[data-splitwise-disconnect-button]").click(function () {
            $('[data-splitwise-disconnect-button]').hide();
            $('[data-splitwise-disconnect-confirm]').fadeIn();
        });

        $("[data-bunq-disconnect-button]").click(function () {
            $('[data-bunq-disconnect-button]').hide();
            $('[data-bunq-disconnect-confirm]').fadeIn();
        });
    </script>
@endpush
