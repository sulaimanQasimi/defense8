import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
  app.component('index-select-department', IndexField)
  app.component('detail-select-department', DetailField)
  app.component('form-select-department', FormField)
})
