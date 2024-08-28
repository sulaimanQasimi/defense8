<template>
  <Card class="flex flex-col items-center justify-center">
    <LoadingView :loading="loading">
    <div class="px-3 py-3">
      <h1 class="text-center text-3xl text-gray-500 font-light">
        {{card.attentenceLabel}}: {{static}} {{ __("Day") }}
      </h1>
    </div>
</LoadingView>
  </Card>

</template>

<script>
export default {
  props: [
    "card",

    // The following props are only available on resource detail cards...
    "resource",
    "resourceId",
    "resourceName",

  ],
data() {
    return {
        loading:true,
        present:Number,
        absent:Number
    }
},
  mounted() {
    Nova.request()
      .get(`/nova-vendor/employee-attendance-statistic/attendance/${this.resourceId}`)
      .then(({ data: { absent, present} }) => {
        this.present = present;
        this.absent = absent;
        this.loading=false;
      })
      .catch((e) => {});
  },
  computed: {
    static(){
        if(this.card.present){
            return this.present;
        }else{
            return this.absent;
        }
    }
  },
};
</script>
