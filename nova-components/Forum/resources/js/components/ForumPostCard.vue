<template>
  <div @click="$emit('visit', resource.id)" class="notification">
    <div class="notiglow"></div>
    <div class="notiborderglow"></div>
    <div class="notititle" v-text="user" />
    <div class="notibody">
      {{ content }}
      <slot />
    </div>
  </div>
</template>
<script>
export default {
  props: {
    user: String,
    content: String,
    resource: Object,
  },
};
</script>
<style scoped>
/* From Uiverse.io by SouravBandyopadhyay */
.notification {
  display: flex;
  flex-direction: column;
  isolation: isolate;
  position: relative;
  width: 18rem;
  height: 8rem;
  border-radius: 1rem;
  overflow: hidden;
  font-family: "Gill Sans", "Gill Sans MT", Calibri, "Trebuchet MS", sans-serif;
  font-size: 16px;
  --gradient: linear-gradient(to bottom, #2eadff, #3d83ff, #7e61ff);
  --color: #32a6ff;
  background-image: linear-gradient(to top, var(--tw-gradient-stops));
  --tw-gradient-from: #7dd3fc var(--tw-gradient-from-position);
  --tw-gradient-to: rgb(125 211 252 / 0) var(--tw-gradient-to-position);
  --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
  --tw-gradient-to: #38bdf8 var(--tw-gradient-to-position);
}

.notification:before {
  position: absolute;
  content: "";
  inset: 0.0625rem;
  border-radius: 0.9375rem;
  --gradient: linear-gradient(to bottom, #2eadff, #3d83ff, #7e61ff);
  --color: #366991;
  background-image: linear-gradient(to top, var(--tw-gradient-stops));
  --tw-gradient-from: rgb(255, 255, 255) var(--tw-gradient-from-position);
  --tw-gradient-to: rgb(125 211 252 / 0) var(--tw-gradient-to-position);
  --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to);
  --tw-gradient-to: rgb(255, 255, 255) var(--tw-gradient-to-position);
  z-index: 2;
}

.notification:after {
  position: absolute;
  content: "";
  width: 0.25rem;
  inset: 0.65rem auto 0.65rem 0.5rem;
  border-radius: 0.125rem;
  background: var(--gradient);
  transition: transform 300ms ease;
  z-index: 4;
}

.notification:hover:after {
  transform: translateX(0.15rem);
}

.notititle {
  color: var(--color);
  padding: 0.65rem 0.25rem 0.4rem 1.25rem;
  font-weight: 500;
  font-size: 1.1rem;
  transition: transform 300ms ease;
  z-index: 5;
}

.notification:hover .notititle {
  transform: translateX(0.15rem);
}

.notibody {
  color: #99999d;
  padding: 0 1.25rem;
  transition: transform 300ms ease;
  z-index: 5;
}

.notification:hover .notibody {
  transform: translateX(0.25rem);
}

.notiglow,
.notiborderglow {
  position: absolute;
  width: 20rem;
  height: 20rem;
  transform: translate(-50%, -50%);
  background: radial-gradient(circle closest-side at center, white, transparent);
  opacity: 0;
  transition: opacity 300ms ease;
}

.notiglow {
  z-index: 3;
}

.notiborderglow {
  z-index: 1;
}

.notification:hover .notiglow {
  opacity: 0.1;
}

.notification:hover .notiborderglow {
  opacity: 0.1;
}

.note {
  color: var(--color);
  position: fixed;
  top: 80%;
  left: 50%;
  transform: translateX(-50%);
  text-align: center;
  font-size: 0.9rem;
  width: 75%;
}
</style>
