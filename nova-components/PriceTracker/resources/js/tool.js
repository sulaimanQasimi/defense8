import Tool from './pages/Tool'
import SearchableInput from './components/SearchableInput'
Nova.booting((app, store) => {
  Nova.inertia('PriceTracker', Tool)
})

Nova.booting((Vue) => {
  Vue.component('searchable-input', SearchableInput);
})