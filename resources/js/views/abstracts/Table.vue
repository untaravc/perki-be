<template>
    <div>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-4 py-3">No</th>
                <th scope="col" class="px-4 py-3">Title</th>
                <th scope="col" class="px-4 py-3">Category</th>
                <th scope="col" class="px-4 py-3">User</th>
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
                    {{ data.title }}
                </td>
                <td class="px-4 py-3">
                    {{ data.category }}
                </td>
                <td class="px-4 py-3">
                    <span v-if="data.user">{{ data.user.name }}</span>
                </td>
                <td class="px-4 py-3">
                    {{ data.created_at | formatDateTime }}
                </td>
                <td class="px-4 py-3">
                    {{ data.status_label }}
                </td>
                <td class="px-4 py-3 flex items-center justify-end">
                    <div class="dropdown relative group">
                        <button
                            class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                            type="button">
                            <unicon name="ellipsis-h"></unicon>
                        </button>
                        <div
                            class="dropdown-menu absolute block hidden group-hover:visible -left-32 z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow">
                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="apple-imac-27-dropdown-button">
                                <li>
                                    <a :href="data.file" target="_blank"
                                       class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        Show
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    props: ['data_content']
}
</script>
<style>
.dropdown:hover .dropdown-menu {
    display: block;
}
</style>
