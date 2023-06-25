<template>
    <aside id="logo-sidebar"
           class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
           aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
            <ul class="space-y-2">
                <li>
                    <router-link to="/panel/dashboard"
                                 class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <svg aria-hidden="true"
                             class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                             fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                        </svg>
                        <span class="ml-3">Dashboards</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/panel/posts"
                                 class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <unicon name="file-check"></unicon>
                        <span class="flex-1 ml-3 whitespace-nowrap">Posts</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/panel/abstracts"
                                 class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <unicon name="file-check"></unicon>
                        <span class="flex-1 ml-3 whitespace-nowrap">Abstracts</span>
                    </router-link>
                </li>
                <li>
                    <router-link to="/panel/transactions"
                                 class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                        <unicon name="file-check"></unicon>
                        <span class="flex-1 ml-3 whitespace-nowrap">Transaksi</span>
                        <span
                            class="inline-flex items-center justify-center px-2 ml-3 text-sm font-medium text-gray-800 bg-gray-200 rounded-full dark:bg-gray-700 dark:text-gray-300">
                            {{ label.transactions }}
                        </span>
                    </router-link>
                </li>
            </ul>
        </div>
    </aside>
</template>
<script>
export default {
    data() {
        return {
            label: {
                transactions: 0,
            }
        }
    },
    methods: {
        loadLabel() {
            this.authGet('adm/sidebar-label')
                .then((data) => {
                    this.label.transactions = data.result.transactions
                })
        }
    },
    created() {
        this.loadLabel()

        Fire.$on('reload-sidebar-label', () => {
            this.loadLabel()
        })
    }
}
</script>
