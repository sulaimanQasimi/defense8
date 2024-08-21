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
        <div>
          <searchable-input
            url="/nova-api/card-infos/associatable/orginization"
            @fire-value="getDepartment"
          />
        </div>
        <div
          class="space-y-2 md:flex @md/modal:flex md:flex-row @md/modal:flex-row md:space-y-0 @md/modal:space-y-0 py-5"
          index="5"
        >
          <div
            class="w-full px-6 md:mt-2 @md/modal:mt-2 md:px-8 @md/modal:px-8 md:w-1/5 @md/modal:w-1/5"
          >
            <label
              for="enter_gate-aygad-mhman-select-field"
              class="inline-block leading-tight space-x-1"
              ><span v-html="__('Year')"></span
              ><span class="text-red-500 text-sm">*</span></label
            >
          </div>
          <div
            class="w-full space-y-2 px-6 md:px-8 @md/modal:px-8 md:w-3/5 @md/modal:w-3/5"
          >
            <!-- Search Input --><!-- Select Input Field -->
            <div class="flex relative w-full">
              <select
                v-model="year"
                id="enter_gate"
                dusk="enter_gate"
                class="w-full block form-control form-control-bordered form-input"
              >
                <option disabled="" value="">یک گزینه را انتخاب کنید</option>
                <option v-for="year in years" v-html="year" v-bind:value="year" />
              </select>
              <svg
                class="shrink-0 text-gray-700 pointer-events-none absolute right-[11px] top-[15px]"
                xmlns="http://www.w3.org/2000/svg"
                width="10"
                height="6"
                viewBox="0 0 10 6"
              >
                <path
                  class="fill-current"
                  d="M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z"
                ></path>
              </svg>
            </div>
            <!--v-if--><!--v-if-->
          </div>
        </div>
        <div
          class="space-y-2 md:flex @md/modal:flex md:flex-row @md/modal:flex-row md:space-y-0 @md/modal:space-y-0 py-5"
          index="5"
        >
          <div
            class="w-full px-6 md:mt-2 @md/modal:mt-2 md:px-8 @md/modal:px-8 md:w-1/5 @md/modal:w-1/5"
          >
            <label
              for="enter_gate-aygad-mhman-select-field"
              class="inline-block leading-tight space-x-1"
              ><span v-html="__('Month')"></span
              ><span class="text-red-500 text-sm">*</span></label
            >
          </div>
          <div
            class="w-full space-y-2 px-6 md:px-8 @md/modal:px-8 md:w-3/5 @md/modal:w-3/5"
          >
            <!-- Search Input --><!-- Select Input Field -->
            <div class="flex relative w-full">
              <select
                v-model="month"
                id="enter_gate"
                dusk="enter_gate"
                class="w-full block form-control form-control-bordered form-input"
              >
                <option disabled="" value="">یک گزینه را انتخاب کنید</option>

                <option value="1" v-html="__('Hamal')"></option>
                <option value="2" v-html="__('Thour')"></option>
                <option value="3" v-html="__('Jawza')"></option>
                <option value="4" v-html="__('Sarathan')"></option>
                <option value="5" v-html="__('Asad')"></option>
                <option value="6" v-html="__('Sunbulah')"></option>
                <option value="7" v-html="__('Mizan')"></option>
                <option value="8" v-html="__('Aqrab')"></option>
                <option value="9" v-html="__('Qous')"></option>
                <option value="10" v-html="__('Jadi')"></option>
                <option value="11" v-html="__('Dalwa')"></option>
                <option value="12" v-html="__('Hod')"></option>
              </select>
              <svg
                class="shrink-0 text-gray-700 pointer-events-none absolute right-[11px] top-[15px]"
                xmlns="http://www.w3.org/2000/svg"
                width="10"
                height="6"
                viewBox="0 0 10 6"
              >
                <path
                  class="fill-current"
                  d="M8.292893.292893c.390525-.390524 1.023689-.390524 1.414214 0 .390524.390525.390524 1.023689 0 1.414214l-4 4c-.390525.390524-1.023689.390524-1.414214 0l-4-4c-.390524-.390525-.390524-1.023689 0-1.414214.390525-.390524 1.023689-.390524 1.414214 0L5 3.585786 8.292893.292893z"
                ></path>
              </svg>
            </div>
            <!--v-if--><!--v-if-->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    cards: Number,
    departments: Object,
    years: Object,
  },
  data() {
    return {
      i: null,
      month: 1,
      year: 1399,
      department: 1,
    };
  },
  computed: {
    link() {
      return (
        "/employee/attendance/current/month/department/" +
        this.department +
        "?month=" +
        this.month +
        "&year=" +
        this.year
      );
    },
  },
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
  },
};
</script>

<style>
/* Scoped Styles */
</style>
