import Tool from './pages/Tool'

import ReportHeader from './components/ReportHeader.vue'
import DateField from './components/DateField.vue'
import MonthField from './components/MonthField.vue'
import EmployeeSearchableInput from './components/EmployeeSearchableInput.vue'
Nova.booting((app, store) => {
  Nova.inertia('OilReport', Tool)
})
Nova.booting((Vue) => {
    Vue.component('report-header', ReportHeader);
    Vue.component('date-field', DateField);
    Vue.component('employee-searchable-input', EmployeeSearchableInput);

})
