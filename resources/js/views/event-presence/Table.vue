<template>
    <div>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-4 py-3">No</th>
                <th scope="col" class="px-4 py-3">Name</th>
                <th scope="col" class="px-4 py-3">Event</th>
                <th scope="col" class="px-4 py-3">Room</th>
                <th scope="col" class="px-4 py-3">Status</th>
                <th scope="col" class="px-4 py-3">
                    Actions
                </th>
            </tr>
            <tr>
                <td class="px-2 py-2"></td>
                <td class="px-2 py-2">
                    <input type="text" v-model="filter.name" @keyup.enter="applyFilter"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                </td>
                <td class="px-2 py-2">
                    <select type="text" v-model="filter.event_id" @change="applyFilter"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        <option value="">All</option>
                        <option :value="evn.id" v-for="evn in params.events">{{evn.name}}</option>
                    </select>
                </td>
                <td class="px-2 py-2">
                    <select type="text" v-model="filter.scanner_id" @change="applyFilter"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        <option value="">All</option>
                        <option :value="adm.id" v-for="adm in params.admin">{{adm.name}}</option>
                    </select>
                </td>
                <td class="px-2 py-2">
                    <select type="text" v-model="filter.status" @change="applyFilter"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                        <option value="">All</option>
                        <option value="100">New</option>
                        <option value="200">Recorded</option>
                    </select>
                </td>
                <td class="px-2 py-2">

                </td>
            </tr>
            </thead>
            <tbody v-if="data_content.data">
            <tr class="border-b" :class="data.has_ws ? 'bg-red-50' : ''"  v-for="(data, i) in data_content.data">
                <td class="px-4 py-3" :title="data.id">
                    {{ (data_content.current_page - 1) * data_content.per_page + i + 1 }}
                </td>
                <td class="px-4 py-3" :title="data.user_id">
                    {{ data.user_name }}
                    <br>
                    {{ data.created_at | formatDateTime }}
                </td>
                <td class="px-4 py-3">
                    <span v-if="data.event">{{ data.event.name }}</span>
                </td>
                <td class="px-4 py-3">
                    <span v-if="data.scanner">{{ data.scanner.name }}</span>
                </td>
                <td>
                    {{ data.status_label }} ({{data.hits}})
                </td>
                <td class="px-4 py-3 flex items-center justify-end">
                    <a :href="'/print/event-presence/' + data.id" target="_blank"
                       class="block py-2 px-4 hover:bg-gray-100">
                        <unicon name="print"></unicon>
                    </a>
                </td>
            </tr>
            </tbody>
        </table>

        <div id="showModal" tabindex="-1" aria-hidden="true"
             class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-3xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow">
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-6 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900 lg:text-2xl">
                            Detail Transaksi
                        </h3>
                        <button type="button" @click="hideModal"
                                class="text-gray-400 bg-transparent text-sm p-1.5 ml-auto inline-flex items-center">
                            <unicon name="times" fill="black"></unicon>
                        </button>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-2">
                            <div class="col-span-2 md:col-span-1">
                                <div class="mb-1 font-semibold">{{ data_detail.number }}</div>
                                <div class="mb-4">Status : {{ data_detail.status_label }}</div>
                                <div v-if="data_detail.transfer_proof">
                                    <div class="italic">Bukti transfer</div>
                                    <div>
                                        <a :href="data_detail.transfer_proof" target="_blank">
                                            <img :src="data_detail.transfer_proof" class="w-full" alt="">
                                            <span class="text-blue-600 hover:text-blue-800">View File</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-2 md:col-span-1 p-2">
                                <div class="mb-2 font-semibold">Identitas</div>
                                <div class="border rounded-lg p-2 mb-4">
                                    <table class="w-full">
                                        <tr>
                                            <td>Nama</td>
                                            <td>:</td>
                                            <td>{{ data_detail.user_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Kode Pekerjaan</td>
                                            <td>:</td>
                                            <td>{{ data_detail.job_type_code }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>:</td>
                                            <td>{{ data_detail.user_email }}</td>
                                        </tr>
                                        <tr>
                                            <td>No Telepon</td>
                                            <td>:</td>
                                            <td>
                                                <a :href="'https://wa.me/' + data_detail.user_phone"></a>
                                                {{ data_detail.user_phone }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal</td>
                                            <td>:</td>
                                            <td>{{ data_detail.created_at | formatDateTime }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="mb-2 font-semibold">Transaksi</div>
                                <div class="border rounded-lg p-2">
                                    <table class="w-full">
                                        <tr>
                                            <td>Subtotal</td>
                                            <td>:</td>
                                            <td class="text-right">{{ data_detail.subtotal | currency }}</td>
                                        </tr>
                                        <tr>
                                            <td>Discount</td>
                                            <td>:</td>
                                            <td class="text-right">{{ data_detail.discount_amount | currency }}</td>
                                        </tr>
                                        <tr>
                                            <td class="border-t">Total</td>
                                            <td class="border-t">:</td>
                                            <td class="text-right border-t">{{ data_detail.total | currency }}</td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="mb-2 font-semibold">Event</div>
                                <div class="border rounded-lg p-2">
                                    <table class="w-full">
                                        <tr v-for="event in data_detail.transaction_details">
                                            <td>{{ event.event_name }}</td>
                                            <td>
                                                <span v-if="event.event">
                                                    {{ event.event.date_start | formatDateTime }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="button" @click="acceptTransaction"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            <span v-if="data_detail.status !== 200">Accept</span>
                            <span v-if="data_detail.status === 200">Resend Email</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
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
                event_id: '',
                scanner_id: '',
            },
            params:{
                admin:[],
                events:[],
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
        loadParams() {
            this.authGet('pub/scan-params').then((data) => {
                if (data.status) {
                    this.params = data.result
                }
            })
        },
        acceptTransaction() {
            if (confirm('Confirm payment?')) {
                this.authPost('adm/transaction-confirm', {
                    transaction_id: this.data_detail.id
                }).then((data) => {
                    if (data.status) {
                        this.modal.hide()
                        this.$parent.loadThisPage();
                    } else {
                        alert(data.message)
                    }
                })
            }
        },
        deleteTransaction(trx) {
            if (confirm('Delete transaction?')) {
                this.authPatch('adm/transaction-delete', {
                    transaction_id: trx.id
                }).then((data) => {
                    if (data.status) {
                        this.$parent.loadThisPage();
                    } else {
                        alert(data.message)
                    }
                });
            }
        },
        applyFilter(){
            this.$parent.applyFilter(this.filter)
        },
    },
    mounted() {
        const $targetEl = document.getElementById('showModal');
        this.modal = new Modal($targetEl);
    },
    created() {
        this.loadParams()

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
