<template>
    <div class="p-4 sm:ml-64">
        <div class="px-4 pt-16 py-6">
            <div class="grid grid-cols-12 gap-2">
                <div class="grid-cols-2 col-span-5 grid gap-2">
                    <div class="bg-white rounded-lg p-4 min-h-100px">
                        <div class="flex mb-2">
                            <div class="bg-teal-500 rounded-lg flex justify-center items-center p-3 inline-block">
                                <unicon name="check-circle" width="30px" fill="white" height="30px"></unicon>
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
                                <unicon name="credit-card" width="30px" fill="white" height="30px"></unicon>
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
                                <unicon name="users-alt" width="30px" height="30px"></unicon>
                            </div>
                        </div>
                        <div>
                            Peserta Terdaftar
                        </div>
                        <div class="text-lg font-semibold">
                            {{ stat.member }}
                        </div>
                    </div>
                    <div class="bg-white rounded-lg p-4 min-h-100px">
                        <div class="flex mb-2">
                            <div class="bg-blue-700 rounded-lg flex justify-center items-center  p-3 inline-block">
                                <unicon name="chart" width="30px" fill="white" height="30px"></unicon>
                            </div>
                        </div>
                        <div>
                            Peserta Event
                        </div>
                        <div class="text-lg font-semibold">
                            {{ stat.member_purchase }}
                        </div>
                    </div>
                </div>
                <div class="col-span-7">
                    <div class="bg-white rounded-xl p-2">
                        chart
                    </div>
                </div>
                <div class="col-span-8">
                    <div class="bg-white rounded-xl p-2">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Event</th>
                                <th scope="col" class="px-4 py-3">Participants</th>
                                <th scope="col" class="px-4 py-3 flex items-center">
                                    <div class="w-3 h-3 bg-blue-300 mx-1"></div>
                                    STD
                                    <div class="w-3 h-3 bg-red-500 mx-1"></div>
                                    GP
                                    <div class="w-3 h-3 bg-green-600 mx-1"></div>
                                    SP
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="border-b dark:border-gray-700" v-for="event in events">
                                <td class="px-4 py-3">
                                    {{ event.name }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ event.transaction_success_count }}
                                </td>
                                <td class="px-2 py-3 relative">
                                    <div class="overflow-hidden h-4 mb-4 text-xs flex rounded bg-slate-200">
                                        <div style="width: 10%"
                                             class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-300">
                                            {{ event.transaction_success_std_count }}
                                        </div>
                                        <div style="width: 15%"
                                             class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-500">
                                            {{ event.transaction_success_gp_count }}
                                        </div>
                                        <div style="width: 25%"
                                             class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-green-600">
                                            {{ event.transaction_success_sp_count }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-span-4">
                    <div class="bg-white rounded-xl p-2">
                        User Group
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
        loadChart() {
            this.authGet('adm/dashboard-chart')
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
