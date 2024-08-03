<template>
  <div class="bg-white px-2 py-1 rounded-xl">
    <div ref="chart"></div>
  </div>
</template>
<script>
import ApexCharts from "apexcharts";
export default {
  props: {
    card: {
      type: Object,
      required: true,
    },
  },
  mounted() {
    console.log(this.card);

    let chart = new ApexCharts(this.$refs.chart, this.card.options);
    chart.render();
  },
};
</script>
