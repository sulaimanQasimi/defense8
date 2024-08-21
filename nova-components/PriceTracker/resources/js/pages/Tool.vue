<template>
  <div>
    <Head :title="__('Attendance Employee Info')" />
    <div class="bg-white px-3 py-4 rounded-2xl">
      <div
        class="text-center font-medium text-2xl text-blue-500"
        v-html="__('Attendance Employee Info')"
      ></div>

      <div
        v-html="__('Through this forms find your information')"
        class="text-sm text-blue-300 text-center"
      ></div>
    </div>

    <div class="mb-2">
      <a
        class="border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center shadow h-9 px-3 bg-primary-500 border-primary-500 hover:[&:not(:disabled)]:bg-primary-400 hover:[&:not(:disabled)]:border-primary-400 text-white dark:text-gray-900 mt-2 mx-2"
        :href="generageLink('excel')"
        target="_blank"
      >
        <span class="dark:text-white fas fa-file-excel mx-2"></span>
      </a>
      <a
        class="border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center shadow h-9 px-3 bg-primary-500 border-primary-500 hover:[&:not(:disabled)]:bg-primary-400 hover:[&:not(:disabled)]:border-primary-400 text-white dark:text-gray-900 mt-2 mx-2"
        :href="generageLink('pdf')"
        target="_blank"
      >
        <span class="dark:text-white fas fa-file-pdf mx-2"></span>
      </a>
    </div>

    <div class="mt-6 bg-white px-3 py-4 rounded-2xl">
      <div class="grid md:grid-cols-3 sm:grid-cols-1 gap-3">

        <div
          class="space-y-2 md:flex @md/modal:flex md:flex-row @md/modal:flex-row md:space-y-0 @md/modal:space-y-0 py-5"
          index="5"
        >
          <div
            class="w-full px-6 md:mt-2 @md/modal:mt-2 md:px-8 @md/modal:px-8 md:w-1/5 @md/modal:w-1/5"
          >
            <FormLabel label-for="year" class="space-x-1">
              <span>
                {{ __("Year") }}
              </span>
            </FormLabel>
          </div>
          <div
            class="w-full space-y-2 px-6 md:px-8 @md/modal:px-8 md:w-3/5 @md/modal:w-3/5"
          >
          <searchable-input
            url="/nova-api/card-infos/associatable/orginization"
            @fire-value="getDepartment"
            :resourceId="department"
          />
        </div>
        </div>


        <div
          class="space-y-2 md:flex @md/modal:flex md:flex-row @md/modal:flex-row md:space-y-0 @md/modal:space-y-0 py-5"
          index="5"
        >
          <div
            class="w-full px-6 md:mt-2 @md/modal:mt-2 md:px-8 @md/modal:px-8 md:w-1/5 @md/modal:w-1/5"
          >

            <FormLabel label-for="year" class="space-x-1">
              <span>
                {{ __("Year") }}
              </span>
            </FormLabel>
          </div>
          <div
            class="w-full space-y-2 px-6 md:px-8 @md/modal:px-8 md:w-3/5 @md/modal:w-3/5"
          >
            <SelectControl
              class="w-full"
              :options="years"
              v-model:selected="year"
              @change="yearRequest"
              label="display"
            >
              <option value="" selected :disabled="true">
                {{ __("Choose an option") }}
              </option>
            </SelectControl>
          </div>
        </div>
        <div
          class="space-y-2 md:flex @md/modal:flex md:flex-row @md/modal:flex-row md:space-y-0 @md/modal:space-y-0 py-5"
          index="5"
        >
          <div
            class="w-full px-6 md:mt-2 @md/modal:mt-2 md:px-8 @md/modal:px-8 md:w-1/5 @md/modal:w-1/5"
          >
            <FormLabel label-for="month" class="space-x-1">
              <span>
                {{ __("Month") }}
              </span>
            </FormLabel>
          </div>
          <div
            class="w-full space-y-2 px-6 md:px-8 @md/modal:px-8 md:w-3/5 @md/modal:w-3/5"
          >
            <SelectControl
              class="w-full"
              :options="months"
              v-model:selected="month"
              @change="monthRequest"
              label="display"
            >
              <option value="" selected :disabled="true">
                {{ __("Choose an option") }}
              </option>
            </SelectControl>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    request: Object,
  },
  data() {
    return {
      i: null,
      month: 1,
      year: 0,
      department: this.request.department,
      months: [],
      years: [],
    };
  },
  mounted() {
    Nova.request()
      .get(` nova-vendor/price-tracker/requirement`)
      .then(({ data: { months, years, currentYear } }) => {
        this.months = months;
        this.years = years;
        this.year = currentYear;
      })
      .catch((e) => {});
    console.log(this.request);
  },
  computed: {},
  methods: {
    getDepartment(value) {
      this.department = value;
    },
    generageLink(type) {
      if (type == "pdf") {
        return `/sq/modules/employee/employee/attendance/current/month/department/${this.department}?month=${this.month}&year=${this.year}`;
      } else {
        return `/sq/modules/employee/employee/attendance/current/month/department/${this.department}/excel?month=${this.month}&year=${this.year}`;
      }
    },
    yearRequest(e) {
        this.year=e
    },
    monthRequest(e) {
        this.month=e
    },
  },
};
</script>

<style>
/* Scoped Styles */
</style>
