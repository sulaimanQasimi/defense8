<template>
  <div ref="chart"></div>
</template>
<script>
import ApexCharts from "apexcharts";
export default {
  mounted() {
    let options = {
      theme: {
        palette: "palette1", // upto palette10
      },
      colors: ["#2E93fA", "#66DA26", "#546E7A", "#E91E63", "#FF9800"],

      monochrome: {
        enabled: true,
        color: "#255aee",
        shadeTo: "light",
        shadeIntensity: 0.65,
      },
      chart: {
        type: "line",
      },
      series: [
        {
          name: "sales",
          data: [30, 40, 35, 50, 49, 60, 70, 91, 125],
        },
      ],
      xaxis: {
        categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998, 1999],
      },
    };

    let chart = new ApexCharts(this.$refs.chart, options);

    chart.render();
  },
};
</script>
