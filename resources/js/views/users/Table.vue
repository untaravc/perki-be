<template>
    <div>
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-3 py-2">No</th>
                <th scope="col" class="px-3 py-2">Name</th>
                <th scope="col" class="px-3 py-2">Email</th>
                <th scope="col" class="px-3 py-2">Phone</th>
                <th scope="col" class="px-3 py-2">Job Code</th>
                <th scope="col" class="px-3 py-2">Type</th>
                <th scope="col" class="px-3 py-2">
                    Actions
                </th>
            </tr>
            </thead>
            <tbody v-if="data_content.data">
            <tr class="border-b" v-for="(data, i) in data_content.data">
                <td class="px-3 py-2">
                    {{(data_content.current_page - 1) * data_content.per_page + i + 1}}
                </td>
                <td class="px-3 py-2">
                    {{data.name}}
                </td>
                <td class="px-3 py-2">
                    {{data.email}}
                    <br>
                    <small>{{data.email_verified_at | formatDateTime}}</small>
                </td>
                <td class="px-3 py-2">
                    {{data.phone}}
                </td>
                <td class="px-3 py-2">
                    {{data.job_type_code}}
                </td>
                <td class="px-3 py-2">
                    {{data.type}}
                </td>
                <td class="px-3 py-2 flex items-center justify-end">
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
                                    <a href="#"
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
