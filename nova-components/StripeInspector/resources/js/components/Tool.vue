<template>
  <Heading :level="1" class="mb-3 flex items-center" dusk="index-heading">
    <span v-html="__('Attendance')" />
  </Heading>
  <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-3">
    <div
      class="space-y-2 md:flex @md/modal:flex md:flex-row @md/modal:flex-row md:space-y-0 @md/modal:space-y-0 py-5"
      index="5"
    >
      <div class="w-full space-y-2 px-6 md:px-8 @md/modal:px-8 md:w-3/5 @md/modal:w-3/5">
        <SelectControl
          class="w-full"
          :options="years"
          v-model:selected="year"
          @change="yearRequest"
          label="display"
        >
          <option value="" selected :disabled="true">
            {{ __("Year") }}
          </option>
        </SelectControl>
      </div>
    </div>
    <div
      class="space-y-2 md:flex @md/modal:flex md:flex-row @md/modal:flex-row md:space-y-0 @md/modal:space-y-0 py-5"
      index="5"
    >
      <div class="w-full space-y-2 px-6 md:px-8 @md/modal:px-8 md:w-3/5 @md/modal:w-3/5">
        <SelectControl
          class="w-full"
          :options="months"
          v-model:selected="month"
          @change="monthRequest"
          label="display"
        >
          <option value="" selected :disabled="true">
            {{ __("Month") }}
          </option>
        </SelectControl>
      </div>
    </div>
  </div>

  <Card>
    <table
      class="w-full divide-y divide-gray-100 dark:divide-gray-700"
      dusk="resource-table"
    >
      <thead class="bg-gray-50 dark:bg-gray-800">
        <tr>
          <td
            v-for="(head, index) in attendances"
            v-text="index"
            class="header border border-gray-200"
          />
        </tr>
        <tr>
          <td v-for="(head, index) in attendances" class="header border border-gray-200">
            <span
              :class="{
                'text-green-500 fas fa-check': head == 'ح',
                'text-red-500 fas fa-xmark': head == 'غ',
                '': head == '',
              }"
            ></span>
          </td>
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
      months: [],
      years: [],
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
      .get(`/nova-vendor/price-tracker/requirement`)
      .then(({ data: { months, years, currentYear } }) => {
        this.months = months;
        this.years = years;
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

  watch: {
    year(newValue, oldValue) {
      Nova.request()
        .get(
          `/nova-vendor/stripe-inspector/attendance/${this.resourceId}?year=${this.year}&month=${this.month}`
        )
        .then(({ data: { absent, attendances, send, present, star } }) => {
          this.attendances = attendances;
        })
        .catch((e) => {});
    },
    month(newValue, oldValue) {
      Nova.request()
        .get(
          `/nova-vendor/stripe-inspector/attendance/${this.resourceId}?year=${this.year}&month=${this.month}`
        )
        .then(({ data: { absent, attendances, send, present, star } }) => {
          this.attendances = attendances;
        })
        .catch((e) => {});
    },
  },
  methods: {
    yearRequest(e) {
      this.year = e;
    },
    monthRequest(e) {
      this.month = e;
    },
  },
};
</script>
<style scoped>
.header {
  text-align: center;
  padding-right: 2px;
  font-size: 20px;
}
table {
  padding: 5px;
}
</style>
