import { defineStore } from 'pinia'
import { reactive } from "vue";

export const useFilterStore = defineStore('filter', () => {
    const app_store = reactive({
        client_id: null,
        client_name: null,
        client_logo: null,
        client_mini_logo: null,
        client_token: null,
        auto_call: false,
        station_id: null,
        role_id: null,
    })

    const category_store = reactive({
        page: 1,
        type: '',
    })

    const transaction_store = reactive({
        page: 1,
        per_page: 25,
        user_name: '',
        section: 'jcu24',
        status: '',
    })

    const voucher_store = reactive({
        page: 1,
        per_page: 25,
        year: '2024',
    })

    const user_store = reactive({
        page: 1,
        per_page: 25,
        type: 'user',
        name: '',
    })

    const role_store = reactive({
        page: 1
    })

    const config_ctk = reactive({
        range: true,
        'only-date': true,
        'no-shortcuts': true,
        format: "YYYY-MM-DD",
        formatted: "ll"
    })

    return {
        role_store,
        category_store,
        app_store,
        config_ctk,
        transaction_store,
        voucher_store,
        user_store,
    }
})
