<template>
    <div>
        <div class="p-3 flex items-center"
            v-if="disks.length > 1">
            <SelectControl
                class="w-full md:w-1/5"
                size="lg"
                :options="getDiscs()"
                :value="activeDisk"
                @input="$emit('update:activeDisk', $event.target.value)"
            />
        </div>

        <div class="overflow-hidden overflow-x-auto relative rounded-lg">
            <table cellpadding="0" cellspacing="0" class="table-default w-full">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide px-2 py-2">
                            {{ __('Path') }}
                        </th>
                        <th class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide px-2 py-2">
                            {{ __('Created at') }}
                        </th>
                        <th class="text-left px-2 whitespace-nowrap uppercase text-gray-500 text-xxs tracking-wide px-2 py-2">
                            {{ __('Size') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <backup
                        v-for="backup in backups"
                        v-bind="backup"
                        :disk="activeDisk"
                        :key="backup.id"
                    />
                    <tr v-if="backups.length === 0">
                        <td class="text-center px-2 py-2" colspan="4">
                            {{ __('No backups present') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>

<script>
import Backup from './Backup';

export default {
    emits: ['setModalVisibility', 'delete'],

    props: {
        disks: { required: true, type: Array },
        activeDisk: { required: true, type: String },
        backups: { required: true, type: Array },
    },

    data() {
        return {

        };
    },

    components: {
        Backup,
    },

    methods: {
        getDiscs() {
            return this.disks.map(val => ({ value: val, label: val }));
        },
    },
};
</script>
