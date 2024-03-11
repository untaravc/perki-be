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

    const role_store = reactive({
        page: 1
    })

    const match_store = reactive({
        page: 1,
        player_id: '',
        competition_id: '',
        player_category_code: '',
        round_category_id: '',
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
        match_store,
    }
})
