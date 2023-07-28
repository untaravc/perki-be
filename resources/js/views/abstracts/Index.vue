<template>
    <div class="p-4 sm:ml-64">
        <div class="mt-14">
            <div class="text-2xl font-bold mb-3">
                Abstract Submission
            </div>
            <section class="bg-gray-50 dark:bg-gray-900">
                <div class="mx-auto max-w-screen-xl">
                    <!-- Start coding here -->
                    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                        <div
                            class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                            <div class="w-full md:w-1/2">
                                <div class="flex items-center">
                                    <div class="relative w-full">
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <unicon name="search"></unicon>
                                        </div>
                                        <input type="text" id="simple-search" v-model="filters.s"
                                               @keyup.enter="loadDataContent"
                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                               placeholder="Search" required="">
                                    </div>
                                </div>
                            </div>
                            <div
                                class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                                <div class="flex">
                                    <a href="/panel/print-abstract?type=full_text" target="_blank"
                                       class="py-2 px-4 mx-1 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 ">
                                        Print Full Text
                                    </a>
                                    <a href="/panel/print-abstract" target="_blank"
                                       class="py-2 px-4 mx-1 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 ">
                                        Print Review
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center mb-2">
                            <div class="inline-flex rounded-md shadow-sm" role="group">
                                <button type="button" @click="filters.status = 0" :class="filters.status === 0 ? 'ring-blue-700' : '' "
                                        class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-l-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700">
                                    Pending {{ stats.pending }}
                                </button>
                                <button type="button" @click="filters.status = 1" :class="filters.status === 1 ? 'ring-blue-700' : '' "
                                        class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700">
                                    Accept {{ stats.accept }}
                                </button>
                                <button type="button" @click="filters.status = 2" :class="filters.status === 2 ? 'ring-blue-700' : '' "
                                        class="px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-r-md hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700">
                                    Decline {{ stats.reject }}
                                </button>
                            </div>
                        </div>
                        <div class="overflow-x-auto" style="min-height: 600px;">
                            <DataTable :data_content="data_content"></DataTable>
                        </div>
                        <nav
                            class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
                            aria-label="Table navigation">
                            <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                                Showing
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{ (data_content.current_page - 1) * data_content.per_page + 1 }}
                                    -
                                    {{ data_content.to }}
                                </span>
                                of
                                <span class="font-semibold text-gray-900 dark:text-white">
                                    {{ data_content.total }}
                                </span>
                            </span>
                            <div>
                                <pagination :data="data_content" :limit="2"
                                            @pagination-change-page="loadDataContent"></pagination>
                            </div>
                        </nav>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>
<script>

import DataTable from "./Table";

export default {
    components: {DataTable},
    data() {
        return {
            data_content: {},
            stats: {
                pending: 0,
                accept: 0,
                reject: 0,
            },
            filters: {
                page: 2,
                per_page: 10,
                s: '',
                status: '',
                type: 'abstract',
            }
        }
    },
    methods: {
        loadDataContent(page = 1) {
            this.filters.page = page
            this.authGet('adm/posts', this.filters)
                .then((data) => {
                    this.data_content = data
                })
        },
        loadStat() {
            this.authGet('adm/posts-stat')
                .then((data) => {
                    this.stats = data.result
                })
        }
    },
    watch: {
        'filters.status'() {
            this.loadDataContent()
        }
    },
    created() {
        this.loadDataContent()
        this.loadStat()
    },
}
</script>
