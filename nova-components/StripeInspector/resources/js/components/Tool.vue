<template>
  <Heading :level="1" class="mb-3 flex items-center" dusk="index-heading">
    <span v-html="__('Attendance')" />
  </Heading>
  <Card>
    <table
      class="w-full divide-y divide-gray-100 dark:divide-gray-700"
      dusk="resource-table"
    >
      <thead class="bg-gray-50 dark:bg-gray-800">
        <tr>
          <td v-for="(head, index) in attendances" v-text="index" class="header border border-gray-200" />
        </tr>       <tr>
          <td v-for="(head, index) in attendances" v-text="head" class="header border border-gray-200"  />
        </tr>
      </thead>


    </table>
  </Card>
</template>

<script>
export default {
  props: ["resourceName", "resourceId", "panel"],
  data() {
    return {
      link: null,
      year: null,
      month: null,
      items: [],
      attendances: [],
    };
  },

  created() {
    Nova.request()
      .get(`/nova-vendor/stripe-inspector/`)
      .then(({ data: { year, month } }) => {
        this.year = year;
        this.month = month;
      })
      .catch((e) => {});

    Nova.request()
      .get(`/nova-vendor/stripe-inspector/attendance/${this.resourceId}`)
      .then(({ data: { absent, attendances, send, present, star } }) => {
        this.attendances = attendances;
      })
      .catch((e) => {});
  },
  mounted() {
    //
  },
};
</script>
<style scoped>
.header{
    padding-right: 2px;
    font-size: 20px;
}
table{
    padding:5px
}
</style>
