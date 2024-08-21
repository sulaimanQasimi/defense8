<template>
  <LoadingView :loading="false">
    <Head :title="__('Guest Report')" />
    <div class="px-3 py-4 rounded-2xl">
      <g-card
        :title="__('Guest Report')"
        :repo="__('Here you can generate guest report')"
      >
        <div class="mt-6 bg-white px-3 py-4 rounded-2xl">
          <div class="grid grid-cols-2 gap-3">
            <div>
              <date-picker range color="#e91e63" v-model="from" clearable />
            </div>
            <searchable-input
              url="/nova-api/card-infos/associatable/orginization"
              @fire-value="getDepartment"
              :resourceId="department"
            />
          </div>
        </div>
      </g-card>
      <div class="flex">
        <a
          v-bind:href="generateLink('excel')"
          target="_blank"
          class="border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center shadow h-9 px-3 bg-primary-500 border-primary-500 hover:[&:not(:disabled)]:bg-primary-400 hover:[&:not(:disabled)]:border-primary-400 text-white dark:text-gray-900 mt-2 mx-2"
        >
          <span class="fas fa-file-excel"></span>
          <span>{{ __("Excel") }}</span>
        </a>
        <a
          v-bind:href="generateLink('pdf')"
          target="_blank"
          class="border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center shadow h-9 px-3 bg-primary-500 border-primary-500 hover:[&:not(:disabled)]:bg-primary-400 hover:[&:not(:disabled)]:border-primary-400 text-white dark:text-gray-900 mt-2 mx-2"
        >
          <span class="fas fa-file-pdf"></span>
          <span>{{ __("PDF") }}</span>
        </a>
      </div>
    </div>
    <guest-details :guests="guests" />
  </LoadingView>
</template>

<script>
import Vue3PersianDatetimePicker from "vue3-persian-datetime-picker";
export default {
  props: {
    request: Object,
    guests: Object,
    now: String,
  },
  components: {
    DatePicker: Vue3PersianDatetimePicker,
  },

  data() {
    return {
      department: this.request.department || '',
      from: this.request.date || this.now,
    };
  },
  watch: {
    from(newValue, oldValue) {
      Nova.visit(`/guest-report?page=1&date=${newValue}&department=${this.department}`);
    },
    department(newValue, oldValue) {
      Nova.visit(`/guest-report?page=1&date=${this.from}&department=${newValue}`);
    },
  },

  created() {
    Nova.request()
      .get(`nova-vendor/guest-report/requirement`)
      .then(({ data: { fields,now } }) => {
        this.headers = fields;
      })
      .catch((e) => {});
  },
  mounted() {
    Nova.addShortcut("ctrl+shift", (event) => {
      Nova.visit("/guest-report");
    });
  },

  methods: {
    getDepartment(value) {
      this.department = value;
    },
    generateLink(type) {
      let reportUrl = Nova.config("report");
      return `${reportUrl}?file=${type}&date=${this.from}&department=${this.department}`;
    },
  },
  computed: {},
};
</script>

<style scoped>
/* Scoped Styles */
.grid {
  display: grid;
}
.grid-cols-2 {
  grid-template-columns: repeat(2, minmax(0, 1fr));
}
.gap-3 {
  gap: 0.75rem;
}
</style>
