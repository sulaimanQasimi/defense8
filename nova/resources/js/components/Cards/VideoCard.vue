/** * */
<template>
  <div>
    <h1
      class="text-center text-2xl font-medium my-3 bg-white py-4 rounded-xl text-blue-600 shadow-md"
      style="text-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2)"
    >
      {{ __("Educational Videos of System") }}
    </h1>

    <div class="bg-white py-2 px-3 shadow-2xl shadow-blue-500/50">
      <div class="grid gap-x-3 gap-y-2 md:grid-cols-4 sm:grid-cols-1">
        <div v-for="(link, index) in card.links" class="">
          <video
            controls
            preload="none"
            style="height: 136px; width: 251px"
            class="rounded-sm"
          >
            <source :src="link" />
          </video>
          <div class="text-blue-500 text-center pt-3" v-html="index"></div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    card: Object,
  },
};
</script>
