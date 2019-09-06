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
}

const actions = {
    [types.GET_MONETARY_ACCOUNTS]: ({commit}) => {
        axios
            .get('/monetary-accounts/')
            .then(res => {
                // Commit our data
                commit(types.MUTATE_MONETARY_ACCOUNTS, res.data)
            })
            .catch(error => {
                console.log(error)
            })
    }
}

export default {
    state,
    getters,
    mutations,
    actions
}
