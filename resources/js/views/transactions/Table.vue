<template>
    <div>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-4 py-3">No</th>
                <th scope="col" class="px-4 py-3">User Name</th>
                <th scope="col" class="px-4 py-3">Type/Nominal</th>
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
                    <select name="" id="" v-model="filter.job_type_code"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">ALL</option>
                        <option value="MHSA">Medical student</option>
                        <option value="COAS">Co-ass</option>
                        <option value="ITRS">Internship</option>
                        <option value="RSDN">Residency</option>
                        <option value="DRGN">General Practitioner</option>
                        <option value="DRSP">Specialist</option>
                        <option value="NURS">Nurse</option>
                        <option value="OTHR">Other Healthcare Provider</option>
                    </select>
                </td>
                <td class="px-2 py-2">
                    <select name="" id="" v-model="filter.status"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">ALL</option>
                        <option value="100">Select Event</option>
                        <option value="110">Waiting payment</option>
                        <option value="120">Waiting confirmation</option>
                        <option value="200">Paid</option>
                        <option value="400">Deleted</option>
                    </select>
                </td>
                <td class="px-2 py-2">

                </td>
            </tr>
            </thead>
            <tbody v-if="data_content.data">
            <tr class="border-b" v-for="(data, i) in data_content.data">
                <td class="px-4 py-3" :title="data.id">
                    {{ (data_content.current_page - 1) * data_content.per_page + i + 1 }}
                </td>
                <td class="px-4 py-3" :title="data.user_id">
                    <a target="_blank" :href="'https://jcu.perki-jogja.com/logas?passcode=JCU23OKE&user_id=' + data.user_id">{{ data.user_name }}</a>
                    <br>
                    <i>{{ data.created_at | formatDateTime }}</i>
                    <br>
                    <a target="_blank" class="text-blue-600 hover:text-blue-800"
                       :href="'https://wa.me/' + data.user_phone_wa">{{ data.user_phone_wa }}</a>
                </td>
                <td class="px-4 py-3">
                    {{ data.job_type_code }}
                    <br>
                    {{ data.total | currency }}
                </td>
                <td>
                    {{ data.status_label }}
                </td>
                <td class="px-4 py-3 flex items-center justify-end">
                    <div class="dropdown relative group">
                        <button
                            class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                            type="button">
                            <unicon name="ellipsis-h"></unicon>
                        </button>
                        <div :class="i > 7 ? '-top-24' : ''"
                             class="dropdown-menu absolute hidden block group-hover:visible -left-32 z-100 w-44 bg-white rounded divide-y divide-gray-100 shadow">
                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="apple-imac-27-dropdown-button">
                                <li>
                                    <a href="#" @click="showModal(data)"
                                       class="block py-2 px-4 hover:bg-gray-100">Show</a>
                                </li>
                                <li>
                                    <a target="_blank" :href="'/print/invoice-pdf/' + data.id"
                                       class="block py-2 px-4 hover:bg-gray-100">Invoice</a>
                                </li>
                                <li>
                                    <a :href="'/print/transaction-presence/' + data.id" target="_blank"
                                       class="block py-2 px-4 hover:bg-gray-100">
                                        Print Name
                                    </a>
                                </li>
                                <li>
                                    <a href="#" @click="deleteTransaction(data)"
                                       class="block py-2 px-4 text-sm text-red-700 hover:bg-gray-100">Delete</a>
                                </li>
                            </ul>
                        </div>
                    </div>
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
                            <unicon name="times"></unicon>
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
                                    <div v-if="data_detail.user && data_detail.user.identity_photo">
                                        Photo ID
                                        <a :href="data_detail.user.identity_photo" target="_blank">
                                            <img :src="data_detail.user.identity_photo" class="w-full" alt="">
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
                                        <tr>
                                            <td>Voucher</td>
                                            <td>:</td>
                                            <td>{{ data_detail.voucher_code }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="mb-2 font-semibold">Transaksi</div>
                                <div class="border rounded-lg p-2">
                                    <table class="w-full">
                                        <tr>
                                            <td>Voucher Code</td>
                                            <td>:</td>
                                            <td class="text-right">{{ data_detail.voucher_code }}</td>
                                        </tr>
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
                                <div v-if="data_detail.users.length > 0">
                                    <div class="mb-2 font-semibold">Children</div>
                                    <div class="border rounded-lg p-2">
                                        <table class="w-full">
                                            <tr v-for="(user, i) in data_detail.users">
                                                <td>{{ i + 1 }}</td>
                                                <td>{{ user.user_name }}</td>
                                                <td>{{ user.user_email }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="mb-2 font-semibold">Update Price</div>
                                <input type="number" v-model="data_detail.total"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="button" @click="acceptTransaction" :disabled="disabled"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            <span v-if="data_detail.status !== 200">Accept</span>
                            <span v-if="data_detail.status === 200">Resend Email</span>
                            <span v-if="disabled">...</span>
                        </button>
                        <a target="_blank" v-if="data_detail.status === 200" :href="'/send-qr-code/' + data_detail.id">
                            Send QrCode
                        </a>
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
            disabled: false,
            modal: '',
            data_detail: {
                users: []
            },
            filter: {
                status: '',
                name: '',
                job_type_code: '',
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
        acceptTransaction() {
            if (confirm('Confirm payment?')) {
                this.disabled = true;
                this.authPost('adm/transaction-confirm', {
                    transaction_id: this.data_detail.id,
                    total: this.data_detail.total,
                }).then((data) => {
                    if (data.status) {
                        this.modal.hide()
                        this.$parent.loadThisPage();
                    } else {
                        alert(data.message)
                    }
                    this.disabled = false;
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
        applyFilter() {
            this.$parent.applyFilter(this.filter)
        }
    },
    mounted() {
        const $targetEl = document.getElementById('showModal');
        this.modal = new Modal($targetEl);
    },
    watch: {
        'filter.status'(val) {
            this.$parent.applyFilter(this.filter)
        },
        'filter.job_type_code'(val) {
            this.$parent.applyFilter(this.filter)
        }
    }
}
</script>
<style>
.dropdown:hover .dropdown-menu {
    display: block;
}
</style>
