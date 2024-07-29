import Tool from './pages/Tool'
import GalaxyCard from './components/GalaxyCard.vue'
import GuestDetails from "./components/GuestDetails";

Nova.booting((app, store) => {

  Nova.inertia('GuestReport', Tool)
})

Nova.booting((Vue) => {

    Vue.component('guest-details', GuestDetails);
    Vue.component('g-card', GalaxyCard);

})


