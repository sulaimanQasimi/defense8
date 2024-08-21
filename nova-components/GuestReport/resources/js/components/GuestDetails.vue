<template>
  <Card>
    <table
      class="w-full divide-y divide-gray-100 dark:divide-gray-700"
      dusk="resource-table"
    >
      <thead class="bg-gray-50 dark:bg-gray-800">
        <tr>
          <th
            v-for="(field, index) in headers"
            :key="index"
            :class="{
              [`text-center`]: true,
              'border-r border-gray-200 dark:border-gray-600': false,
              'px-6': true,
            }"
            class="uppercase text-gray-500 text-xxs tracking-wide py-2"
          >
            {{ field.label }}
          </th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
        <tr class="group" v-for="guest in guests.data" @click.stop.prevent="handleClick(guest.id)">
          <!-- Fields -->
          <td
            v-for="(field, index) in headers"
            class="px-2 py-2 whitespace-nowrap cursor-pointer dark:bg-gray-800 group-hover:bg-gray-50 dark:group-hover:bg-gray-900"
            v-text="guest[field.key]"
            :class="{
              [`text-center`]: true,
              'px-6': true,
              'px-2': true,
            }"
          />
        </tr>
      </tbody>
    </table>
  </Card>
</template>
<script>
export default {
  props: {
    guests: Object,
  },
  data() {
    return {
      headers: [],
    };
  },
  created() {
    Nova.request()
      .get(`nova-vendor/guest-report/requirement`)
      .then(({ data: { fields } }) => {
        this.headers = fields;
      })
      .catch((e) => {});
  },
  methods: {
    handleClick(id){
        Nova.visit(`/resources/guests/${id}`)
    }
  },
};
</script>
