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
        {{ 'bunq.no_monetary_accounts_found' | translate }}
    </div>
</template>

<script>
    export default {
        data() {
            return {}
        },
        computed: {
            monetaryAccounts() {
                return this.$store.getters.monetaryAccounts
            }
        },
        methods: {
            selectAccount(monetaryAccount) {
                console.log(monetaryAccount)
            }
        }
    }
</script>

<style scoped>
    .cursor-pointer {
        cursor: pointer;
    }
</style>
