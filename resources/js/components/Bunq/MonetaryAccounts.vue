<template>
    <ul class="list-group">
        <li
                v-if="monetaryAccounts.length > 0"
                v-for="monetaryAccount in monetaryAccounts"
                @click="selectAccount(monetaryAccount)"
                class="list-group-item d-flex justify-content-between align-items-center cursor-pointer">
            {{ monetaryAccount.description }}
            <span class="badge badge-primary badge-pill">
                {{ monetaryAccount.balance }}
            </span>
        </li>

        <li v-else class="list-group-item d-flex justify-content-between align-items-center">
            'bunq.no_monetary_accounts_found'
        </li>

    </ul>
</template>

<script>
    export default {
        data() {
            return {
                monetaryAccounts: [
                    {id: 1, description: 'Main', balance: 1234.56},
                    {id: 2, description: 'Savings', balance: 15000.00},
                    {id: 3, description: 'Travel', balance: 0.50},
                ]
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
