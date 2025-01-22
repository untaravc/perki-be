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

    const date_config = reactive({
        'range': true,
        'no-shortcuts': true,
        'no-label': true,
        'no': true,
        'formatted': 'll',
        'locale': "id",
        'only-date': true,
        'input-size': 'sm',
    })

    const category_store = reactive({
        page: 1,
        type: '',
    })

    const transaction_store = reactive({
        page: 1,
        per_page: 25,
        user_name: '',
        section: 'carvep',
        status: '',
        dates: '',
    })

    const transaction_validate_store = reactive({
        page: 1,
        per_page: 1,
        section: 'jcu24',
    })

    const presence_store = reactive({
        event_id: 1,
        page: 1,
        per_page: 50,
        name: '',
        align: 'center',
    })

    const post_store = reactive({
        page: 1,
        per_page: 25,
        title: '',
        year: '2024',
        status: '',
        category: '',
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
        date_config,
        presence_store,
        post_store
    }
})
