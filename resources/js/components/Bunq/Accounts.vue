<template>
    <ul class="list-group">
        @forelse($monetaryAccounts as $monetaryAccount)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="{{ route('bunq.monetary-accounts.show', ['monetaryAccountId' => $monetaryAccount->getReferencedObject()->getId()]) }}">
                {{ $monetaryAccount->getReferencedObject()->getDescription() }}
            </a>
            <span class="badge badge-primary badge-pill">
                @price($monetaryAccount->getReferencedObject()->getBalance()->getValue())
            </span>
        </li>
        @empty
        <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ __('bunq.no_monetary_accounts_found') }}
        </li>
        @endforelse
    </ul>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
