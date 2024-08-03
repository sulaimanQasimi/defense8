<template>
  <div ref="chartopkl"></div>
</template>
<script>
import Chart from "chart.js/auto";
export default {
  props: {
    card: {
      type: Object,
      required: true,
    },
  },
  mounted() {
  let chart=  new Chart(this.$refs.chartopkl, {
      data: {
        datasets: [
          {
            type: "bar",
            label: "Bar Dataset",
            data: [10, 20, 30, 40],
          },
        ],
        labels: ["January", "February", "March", "April"],
      }, // 5: fill to axis value 25
    });
  },
};
</script>
