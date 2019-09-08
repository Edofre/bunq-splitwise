<template>
    <ul v-if="monetaryAccounts.length > 0" class="list-group">
        <li
                v-for="monetaryAccount in monetaryAccounts"
                @click="selectAccount(monetaryAccount)"
                class="list-group-item d-flex justify-content-between align-items-center cursor-pointer">
            {{ monetaryAccount.description }}
            <span class="badge badge-primary badge-pill">
                {{ monetaryAccount.balance }}
            </span>
        </li>
    </ul>
    <div v-else>
        <div v-if="loadingMonetaryAccounts">
            <i class="fas fa-spinner fa-spin"></i>
        </div>
        <div v-else>
            {{ 'bunq.no_monetary_accounts_found' | translate }}
        </div>
    </div>
</template>

<script>
    import {GET_MONETARY_ACCOUNTS} from "../../store/types";

    export default {
        data() {
            return {}
        },
        computed: {
            monetaryAccounts() {
                return this.$store.getters.monetaryAccounts
            },
            loadingMonetaryAccounts() {
                return this.$store.getters.loadingMonetaryAccounts
            }
        },
        methods: {
            selectAccount(monetaryAccount) {
                window.location.href = route('bunq.monetary-accounts.show', {monetaryAccountId: monetaryAccount.id})

            }
        },
        mounted() {
            this.$store.dispatch(GET_MONETARY_ACCOUNTS)
        }
    }
</script>

<style scoped>
    .cursor-pointer {
        cursor: pointer;
    }
</style>
