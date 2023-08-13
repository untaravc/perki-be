<template>
    <div>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-4 py-3">No</th>
                <th scope="col" class="px-4 py-3">Dikirim</th>
                <th scope="col" class="px-4 py-3">Kategori</th>
                <th scope="col" class="px-4 py-3">Pengirim</th>
                <th scope="col" class="px-4 py-3">Status</th>
            </tr>
            <tr>
                <td class="px-2 py-2"></td>
                <td class="px-2 py-2">
                    <input type="text" v-model="filter.name" @keyup.enter="applyFilter"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </td>
                <td class="px-2 py-2">
                    <input type="text" v-model="filter.label" @keyup.enter="applyFilter"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </td>
                <td class="px-2 py-2">

                </td>
                <td class="px-2 py-2">
                    <select type="text" v-model="filter.status" @change="applyFilter"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        <option value="">All</option>
                        <option value="0">Pending</option>
                        <option value="1">Sent</option>
                        <option value="2">Failed</option>
                    </select>
                </td>
            </tr>
            </thead>
            <tbody v-if="data_content.data">
            <tr class="border-b" v-for="(data, i) in data_content.data">
                <td class="px-4 py-3" :title="data.id">
                    {{ (data_content.current_page - 1) * data_content.per_page + i + 1 }}
                </td>
                <td class="px-4 py-3" :title="data.user_id">
                    {{ data.email_receiver }}
                    <br>
                    <small>{{ data.receiver_name }}</small>
                </td>
                <td class="px-4 py-3">
                    <span>{{ data.label }}</span>
                </td>
                <td class="px-4 py-3">
                    {{ data.email_sender }}
                    <br>
                    {{ data.created_at }}
                </td>
                <td>
                    {{ data.status_label }}
                </td>
            </tr>
            </tbody>
        </table>

    </div>
</template>
<script>
export default {
    data() {
        return {
            modal: '',
            data_detail: '',
            filter: {
                status: '',
                name: '',
                label: '',
            },
            params: {
                admin: [],
                events: [],
            }
        }
    },
    props: ['data_content'],
    methods: {
        showModal(data) {
            this.data_detail = data
            this.modal.show();
        },
        hideModal() {
            this.modal.hide()
        },
        applyFilter() {
            this.$parent.applyFilter(this.filter)
        },
    },
    mounted() {
        const $targetEl = document.getElementById('showModal');
        this.modal = new Modal($targetEl);
    },
    created() {

    },
    watch: {
        'filter.status'(val) {
            this.$parent.applyFilter(this.filter)
        }
    },
}
</script>
<style>
.dropdown:hover .dropdown-menu {
    display: block;
}
</style>
