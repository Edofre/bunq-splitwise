@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="col-sm-12 row">
                            @if(is_null($bunqToken))
                                <div class="col-sm-6">
                                    <a href="{{ route('bunq.oauth.authorize') }}" class="btn btn-primary">
                                        <i class="fas fa-piggy-bank"></i>
                                        Authorize bunq
                                    </a>
                                </div>
                            @else

                            @endif

                            @if(is_null($splitwiseToken))
                                <div class="col-sm-6">
                                    <a href="{{ route('splitwise.oauth.authorize') }}" class="btn btn-primary">
                                        <i class="fas fa-money-check-alt"></i>
                                        {{ __('splitwise.authorize_splitwise') }}
                                    </a>
                                </div>
                            @else

                                <div data-splitwise-disconnect-button class="btn btn-success">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                    {{ __('splitwise.splitwise_connected') }}
                                </div>

                                <div data-splitwise-disconnect-confirm style="display: none;">
                                    <a class="btn btn-danger" href="{{ route('splitwise.oauth.disconnect') }}" onclick="event.preventDefault(); document.getElementById('splitwise-disconnect-form').submit();">
                                        <i class="fa fa-cross" aria-hidden="true"></i>
                                        {{ __('splitwise.disconnect_splitwise') }}
                                    </a>
                                    <form id="splitwise-disconnect-form" action="{{ route('splitwise.oauth.disconnect') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            @endif
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
    </script>
@endpush
