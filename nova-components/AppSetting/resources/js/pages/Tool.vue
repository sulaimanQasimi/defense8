<template>
  <div>
    <Head :title="__('App Setting')" />
    <LoginPageSettings />
    <AttendanceTimerSettings />
  </div>
</template>
<script>
import LoginPageSettings from "../components/LoginPageSettings";
import AttendanceTimerSettings from "../components/AttendanceTimerSettings.vue";
export default {
  components: {
    LoginPageSettings,
    AttendanceTimerSettings,
  },
};
</script>
<style>
/* Scoped Styles */
</style>
