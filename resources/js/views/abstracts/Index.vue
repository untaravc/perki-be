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
                                <!--                                <button type="button"-->
                                <!--                                        class="flex items-center justify-center text-white bg-primary hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 focus:outline-none">-->
                                <!--                                    <unicon name="plus" fill="white"></unicon>-->
                                <!--                                    Add product-->
                                <!--                                </button>-->
                                <div class="flex items-center space-x-3 w-full md:w-auto">
                                    <!--                                    <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown"-->
                                    <!--                                            class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"-->
                                    <!--                                            type="button">-->
                                    <!--                                        <unicon name="angle-down"></unicon>-->
                                    <!--                                        Actions-->
                                    <!--                                    </button>-->
                                    <div id="actionsDropdown"
                                         class="hidden z-10 w-44 m-0 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                            aria-labelledby="actionsDropdownButton">
                                            <li>
                                                <a href="#"
                                                   class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mass
                                                    Edit</a>
                                            </li>
                                        </ul>
                                    </div>
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
                                    <div id="filterDropdown"
                                         class="z-10 hidden m-0 w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700">
                                        <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">
                                            Status
                                        </h6>
                                        <ul class="space-y-2 text-sm" aria-labelledby="filterDropdownButton">
                                            <li class="flex items-center">
                                                <input id="apple" type="checkbox" value=""
                                                       class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                <label for="apple"
                                                       class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    Status
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto" style="min-height: 600px;">
                            <Table :data_content="data_content"></Table>
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

import Table from "./Table";

export default {
    components: {Table},
    data() {
        return {
            data_content: {},
            filters: {
                page: 2,
                per_page: 10,
                s: '',
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
        }
    },
    created() {
        this.loadDataContent()
    },
}
</script>
