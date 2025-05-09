import FingerprintField from '../components/FingerprintField'

Nova.booting((app, store) => {
  app.component('fingerprint-field', FingerprintField)
})