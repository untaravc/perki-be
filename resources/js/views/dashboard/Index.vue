<template>
    <div class="p-2 md:p-4 sm:ml-64">
        <div class="px-0 md:px-4 pt-16 py-6">
            <div class="grid grid-cols-12 gap-2">
                <div class="grid-cols-2 md:col-span-5 col-span-12 grid gap-2">
                    <div class="bg-white rounded-lg p-4 min-h-100px">
                        <div class="flex mb-2">
                            <div class="bg-teal-500 rounded-lg flex justify-center items-center p-3 inline-block">
                                <unicon name="check-circle" width="20px" fill="white" height="20px"></unicon>
                            </div>
                        </div>
                        <div>
                            Transaksi Berhasil
                        </div>
                        <div class="text-lg font-semibold ">
                            {{ stat.transaction_success }}
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-4 min-h-100px">
                        <div class="flex mb-2">
                            <div class="bg-blue-800 rounded-lg flex justify-center items-center p-3 inline-block">
                                <unicon name="credit-card" width="20px" fill="white" height="20px"></unicon>
                            </div>
                        </div>
                        <div>
                            Total Pendapatan
                        </div>
                        <div class="text-lg font-semibold ">
                            {{ stat.transaction_success_nominal | currency }}
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-4 min-h-100px">
                        <div class="flex mb-2">
                            <div class="bg-yellow-300 rounded-lg flex justify-center items-center  p-3 inline-block">
                                <unicon name="users-alt" width="20px" height="20px"></unicon>
                            </div>
                        </div>
                        <div>
                            Akun Terdaftar
                        </div>
                        <div class="text-lg font-semibold">
                            {{ stat.member }}
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-4 min-h-100px">
                        <div class="flex mb-2">
                            <div class="bg-blue-700 rounded-lg flex justify-center items-center  p-3 inline-block">
                                <unicon name="chart" width="20px" fill="white" height="20px"></unicon>
                            </div>
                        </div>
                        <div>
                            Peserta Acara
                        </div>
                        <div class="text-lg font-semibold">
                            {{ stat.member_purchase }}
                        </div>
                    </div>
                </div>
                <div class="md:col-span-7 col-span-12">
                    <div class="bg-white rounded-xl p-2">
                        <TransactionChart :height="300"></TransactionChart>
                    </div>
                </div>
                <div class="md:col-span-6 col-span-12">
                    <div class="bg-white rounded-xl p-2">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Event</th>
                                <th scope="col" class="px-4 py-3 text-center">Participants</th>
                                <th scope="col" class="px-4 py-3 flex items-center">
                                    <div class="w-3 h-3 bg-blue-300 mx-1"></div>
                                    STD
                                    <div class="w-3 h-3 bg-blue-800 mx-1"></div>
                                    GP
                                    <div class="w-3 h-3 bg-green-600 mx-1"></div>
                                    SP
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="border-b dark:border-gray-700" v-for="event in events">
                                <td class="px-2 py-1">
                                    {{ event.name }}
                                    <br> <small>{{ event.title | truncate(50) }}</small>
                                </td>
                                <td class="px-2 py-1 text-center">
                                    {{ event.transaction_success_count }}
                                </td>
                                <td class="px-2 py-1">
                                    <div class="relative">
                                        <div class="overflow-hidden h-4 my-1 text-xs flex rounded bg-slate-200">
                                            <div v-if="event.transaction_success_std_count > 0"
                                                 :style="'width: '+ event.transaction_success_std_count / event.transaction_success_count * 100 +'%'"
                                                 class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-300">
                                                {{ event.transaction_success_std_count }}
                                            </div>
                                            <div v-if="event.transaction_success_gp_count > 0"
                                                 :style="'width: '+ event.transaction_success_gp_count / event.transaction_success_count * 100 +'%'"
                                                 class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-800">
                                                {{ event.transaction_success_gp_count }}
                                            </div>
                                            <div v-if="event.transaction_success_sp_count > 0"
                                                 :style="'width: '+ event.transaction_success_sp_count / event.transaction_success_count * 100 +'%'"
                                                 class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-green-600">
                                                {{ event.transaction_success_sp_count }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="md:col-span-3 col-span-12">
                    <div class="bg-white rounded-xl p-2">
                        <div class="mb-4">
                            <h4 class="text-lg font-semibold">
                                Job Type
                            </h4>
                            <UserChart></UserChart>
                        </div>
                    </div>
                </div>
                <div class="md:col-span-3 col-span-12">
                    <div class="bg-white rounded-xl p-2">
                        <div class="mb-4">
                            <h4 class="text-lg font-semibold">
                                Abstract
                            </h4>
                            <AbstractChart></AbstractChart>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import TransactionChart from './TransactionChart'
import UserChart from './UserChart'
import AbstractChart from './AbstractChart'

export default {
    components: {TransactionChart, UserChart, AbstractChart},
    data() {
        return {
            stat: {
                member: 0,
                member_purchase: 0,
                transaction_success: 0,
                transaction_success_nominal: 0,
            },
            member: [],
            chart: {},
            events: [],
        }
    },
    methods: {
        loadStat() {
            this.authGet('adm/dashboard-stat')
                .then((data) => {
                    this.stat = data.result.stat
                    this.member = data.result.member
                })
        },
        loadEventPurchase() {
            this.authGet('adm/dashboard-event-purchase')
                .then((data) => {
                    this.events = data.result
                })
        },
    },
    created() {
        this.loadStat();
        this.loadEventPurchase();
    }
}
</script>
