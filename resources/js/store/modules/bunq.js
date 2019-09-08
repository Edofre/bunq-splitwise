import axios from 'axios'
import * as types from '../types'

const state = {
    monetaryAccounts: [],
    loadingMonetaryAccounts: false
}

const getters = {
    monetaryAccounts: (state) => {
        return state.monetaryAccounts
    },
    loadingMonetaryAccounts: (state) => {
        return state.loadingMonetaryAccounts
    }
}

const mutations = {
    [types.MUTATE_MONETARY_ACCOUNTS]: (state, monetaryAccounts) => {
        state.monetaryAccounts = monetaryAccounts
    },
    [types.MUTATE_LOADING_MONETARY_ACCOUNTS]: (state, loadingMonetaryAccounts) => {
        state.loadingMonetaryAccounts = loadingMonetaryAccounts
    },
}

const actions = {
    [types.GET_MONETARY_ACCOUNTS]: ({commit}) => {
        commit(types.MUTATE_LOADING_MONETARY_ACCOUNTS, true);
        axios
            .get(route('bunq.monetary-accounts.data'))
            .then(res => {
                // Commit our data
                commit(types.MUTATE_MONETARY_ACCOUNTS, res.data.data)
            })
            .catch(error => {
                console.log(error)
            })
            .finally(() => {
                commit(types.MUTATE_LOADING_MONETARY_ACCOUNTS, false)
            })
    }
}

export default {
    state,
    getters,
    mutations,
    actions
}
