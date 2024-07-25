<template>
  <LoadingView :loading="initialLoading">
    <div>
      <Head :title="__('Guest Report')" />
      <report-header />
      <date-field
        :years="years"
        :days="days"
        title="Start Date"
        @month="set_start_month($event.target.value)"
        @year="set_start_year($event.target.value)"
        @day="set_start_day($event.target.value)"
      />
      <date-field
        :years="years"
        :days="days"
        title="End Date"
        @month="set_end_month($event.target.value)"
        @year="set_end_year($event.target.value)"
        @day="set_end_day($event.target.value)"
      />
    </div>
    <a class="border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center shadow h-9 px-3 bg-primary-500 border-primary-500 hover:[&:not(:disabled)]:bg-primary-400 hover:[&:not(:disabled)]:border-primary-400 text-white dark:text-gray-900  mt-2" v-bind:href="reportUrl" href="#" target="_blank" v-html="__('Create')"></a>

  </LoadingView>
</template>

<script>
export default {
  emits: ["get_date"],
  props: {
    days: Object,
    years: Object,
    url:String
  },
  data() {
    return {
      startDay: 1,
      startMonth: 1,
      startYear: 1399,
      endDay: 1,
      endMonth: 1,
      endYear: 1399,
      initialLoading: false,
    };
  },
  watch: {

  },
  mounted() {},
  methods: {
    set_start_month(value) {
      this.startMonth = value;
      this.$emit('get_date')
    },
    set_start_year(value) {
      this.startYear = value;
    },
    set_start_day(value) {
      this.startDay = value;
    },

    set_end_month(value) {
      this.endMonth = value;
    },
    set_end_year(value) {
      this.endYear = value;
    },
    set_end_day(value) {
      this.endDay = value;
    },
  },
  computed: {
    reportUrl(){
        return this.url+"?startYear="+this.startYear+"&startMonth="+this.startMonth+"&startDay="+this.startDay+"&endYear="+this.endYear+"&endMonth="+this.endMonth+"&endDay="+this.endDay;
    }
  },
};
</script>

<style>
/* Scoped Styles */
.grid {
  display: grid;
}
.grid-cols-4 {
  grid-template-columns: repeat(3, minmax(0, 1fr));
}
</style>
