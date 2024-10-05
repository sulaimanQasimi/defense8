<template>
    <tr :class="{ 'is-deleting': deleting }">
        <td class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">{{ path }}</td>
        <td class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">{{ date }}</td>
        <td class="px-2 py-2 border-t border-gray-100 dark:border-gray-700 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900">{{ size }}</td>

    </tr>
</template>

<script>
export default {
    props: {
        date: { required: true },
        path: { required: true },
        size: { required: true },
        disk: { required: true },
    },

    computed: {
        downloadUrl() {
            const endpoint = '/nova-vendor/spatie/backup-tool/download-backup';

            return `${endpoint}?disk=${this.disk}&path=${this.path}`;
        },
    },
};
</script>

<style scoped>
.is-deleting td {
    color: var(--60);
}
</style>
