<template>
    <div>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-4 py-3">No</th>
                <th scope="col" class="px-4 py-3">User Name</th>
                <th scope="col" class="px-4 py-3">Nominal</th>
                <th scope="col" class="px-4 py-3">Date</th>
                <th scope="col" class="px-4 py-3">Status</th>
                <th scope="col" class="px-4 py-3">
                    Actions
                </th>
            </tr>
            </thead>
            <tbody v-if="data_content.data">
            <tr class="border-b" v-for="(data, i) in data_content.data">
                <td class="px-4 py-3">
                    {{ (data_content.current_page - 1) * data_content.per_page + i + 1 }}
                </td>
                <td class="px-4 py-3">
                    {{ data.user_name }}
                </td>
                <td class="px-4 py-3">
                    {{ data.total | currency }}
                </td>
                <td class="px-4 py-3">
                    {{ data.created_at | formatDateTime }}
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
                        <div :class="i > 7 ? '-top-36' : ''"
                             class="dropdown-menu absolute hidden block group-hover:visible -left-32 z-100 w-44 bg-white rounded divide-y divide-gray-100 shadow">
                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="apple-imac-27-dropdown-button">
                                <li>
                                    <a href="#" @click="showModal(data)"
                                       class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Show</a>
                                </li>
                                <li>
                                    <a href="#"
                                       class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                </li>
                            </ul>
                            <div class="py-1">
                                <a href="#"
                                   class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                            </div>
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
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="button" @click="hideModal"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Accept
                        </button>
                        <button type="button" @click="hideModal"
                                class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">
                            Decline
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
        }
    },
    mounted() {
        const $targetEl = document.getElementById('showModal');
        this.modal = new Modal($targetEl);
    }
}
</script>
<style>
.dropdown:hover .dropdown-menu {
    display: block;
}
</style>
