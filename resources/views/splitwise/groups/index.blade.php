@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-users"></i>
                        {{ __('splitwise.groups') }}
                    </div>

                    <div class="card-body">
                        @forelse($groups as $group)
                            <div class="media">
                                <img src="{{ $group->avatar->medium }}" class="mr-3" alt="{{ $group->name }}">
                                <div class="media-body">
                                    <h5 class="mt-0">
                                        <a href="{{ route('splitwise.groups.show', ['id' => $group->id]) }}">
                                            {{ $group->name }}
                                        </a>
                                    </h5>
                                </div>
                            </div>
                        @empty
                            {{ __('splitwise.no_groups_found') }}
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
