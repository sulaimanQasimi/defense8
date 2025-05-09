<template>
  <default-field :field="field" :errors="errors" :show-help-text="showHelpText">
    <template #field>
      <div class="fingerprint-field" :class="{ 'is-capturing': isCapturing, 'has-fingerprint': hasFingerprint }">
        <div v-if="!isCapturing && !hasFingerprint" class="fingerprint-placeholder">
          <div class="flex flex-col items-center justify-center p-4 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800" style="min-height: 200px;">
            <div class="mb-3 text-gray-500 dark:text-gray-400">{{ field.placeholderText }}</div>
            <button
              type="button"
              class="btn btn-default btn-primary"
              @click="startCapture"
              :disabled="isReadonly"
            >
              {{ field.captureButtonText }}
            </button>
          </div>
        </div>

        <div v-if="hasFingerprint && !isCapturing" class="fingerprint-preview">
          <div class="flex flex-col items-center p-4 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800">
            <img
              v-if="fingerprintImageUrl"
              :src="fingerprintImageUrl"
              alt="Fingerprint"
              class="mb-3 border border-gray-300 dark:border-gray-700 rounded"
              :style="`max-width: ${field.imageWidth}px; max-height: ${field.imageHeight}px;`"
            />
            <div v-else class="mb-3 flex items-center justify-center border border-gray-300 dark:border-gray-700 rounded" :style="`width: ${field.imageWidth}px; height: ${field.imageHeight}px;`">
              <span class="text-gray-500 dark:text-gray-400">Fingerprint captured (no preview)</span>
            </div>

            <div class="flex space-x-2">
              <button
                type="button"
                class="btn btn-default btn-primary"
                @click="startCapture"
                :disabled="isReadonly"
              >
                {{ field.recaptureButtonText }}
              </button>
              <button
                type="button"
                class="btn btn-default btn-danger"
                @click="removeFingerprint"
                :disabled="isReadonly"
              >
                {{ field.deleteButtonText }}
              </button>
            </div>
          </div>
        </div>

        <div v-if="isCapturing" class="fingerprint-capture">
          <div class="flex flex-col items-center p-4 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800">
            <div class="scanner-animation mb-3 flex items-center justify-center border border-gray-300 dark:border-gray-700 rounded" :style="`width: ${field.imageWidth}px; height: ${field.imageHeight}px;`">
              <div class="scanner-line"></div>
            </div>

            <div class="mb-3 text-gray-700 dark:text-gray-300">Place your finger on the scanner</div>

            <div class="flex space-x-2">
              <button
                type="button"
                class="btn btn-default btn-danger"
                @click="cancelCapture"
              >
                {{ field.cancelButtonText }}
              </button>
            </div>
          </div>
        </div>

        <div v-if="field.debug && debugLogs.length > 0" class="debug-logs mt-2 p-2 border border-gray-300 dark:border-gray-700 rounded-lg bg-gray-50 dark:bg-gray-800 overflow-auto text-xs font-mono" style="max-height: 150px;">
          <div v-for="(log, index) in debugLogs" :key="index" class="debug-log">
            {{ log }}
          </div>
        </div>
      </div>
    </template>
  </default-field>
</template>

<script>
export default {
  name: 'FingerprintField',

  props: ['field', 'resourceName', 'resourceId', 'errors', 'showHelpText'],

  data() {
    return {
      isCapturing: false,
      hasFingerprint: false,
      fingerprintImageUrl: null,
      fingerprintData: {
        ISOTemplateBase64: null,
        TemplateBase64: null,
        BMPBase64: null,
        Manufacturer: null,
        Model: null,
        SerialNumber: null,
        ImageWidth: null,
        ImageHeight: null,
        ImageDPI: null,
        ImageQuality: null,
        NFIQ: null,
      },
      debugLogs: [],
    }
  },

  computed: {
    isReadonly() {
      return this.field.readonly || this.field.readOnly
    },
  },

  mounted() {
    this.initField()
  },

  methods: {
    initField() {
      // Check if we have data in the field
      if (this.field.value) {
        this.hasFingerprint = true

        // If the field value is a string, assume it's the ISOTemplateBase64
        if (typeof this.field.value === 'string') {
          this.fingerprintData.ISOTemplateBase64 = this.field.value
        }
        // If it's an object, it might contain multiple properties
        else if (typeof this.field.value === 'object') {
          this.fingerprintData = { ...this.fingerprintData, ...this.field.value }
        }

        // If we have BMPBase64, create an image URL for preview
        if (this.fingerprintData.BMPBase64) {
          this.fingerprintImageUrl = `data:image/bmp;base64,${this.fingerprintData.BMPBase64}`
        }

        this.log('Loaded existing fingerprint data')
      }
    },

    log(message) {
      if (this.field.debug) {
        const timestamp = new Date().toLocaleTimeString()
        this.debugLogs.push(`[${timestamp}] ${message}`)

        // Keep only the latest 100 logs
        if (this.debugLogs.length > 100) {
          this.debugLogs.shift()
        }

        // Scroll to bottom of logs
        this.$nextTick(() => {
          const debugLogs = document.querySelector('.debug-logs')
          if (debugLogs) {
            debugLogs.scrollTop = debugLogs.scrollHeight
          }
        })
      }
    },

    startCapture() {
      this.isCapturing = true
      this.log('Starting fingerprint capture')

      // In a real implementation, this would interact with a fingerprint SDK
      // For demo purposes, we'll simulate a capture after a delay
      setTimeout(() => {
        this.simulateCapture()
      }, 3000)
    },

    cancelCapture() {
      this.isCapturing = false
      this.log('Capture cancelled')
    },

    removeFingerprint() {
      this.hasFingerprint = false
      this.fingerprintImageUrl = null
      this.fingerprintData = {
        ISOTemplateBase64: null,
        TemplateBase64: null,
        BMPBase64: null,
        Manufacturer: null,
        Model: null,
        SerialNumber: null,
        ImageWidth: null,
        ImageHeight: null,
        ImageDPI: null,
        ImageQuality: null,
        NFIQ: null,
      }

      this.log('Fingerprint removed')

      // Update the field value
      this.updateFieldValue()
    },

    simulateCapture() {
      // Simulate a successful capture
      this.log('Fingerprint captured successfully')

      // In a real implementation, this would come from the SDK
      // For demo purposes, we'll use mock data
      const mockData = {
        ISOTemplateBase64: 'mockISOTemplateData' + Date.now(),
        TemplateBase64: 'mockTemplateData' + Date.now(),
        BMPBase64: this.createMockBMP(),
        Manufacturer: 'Mock Scanner',
        Model: 'Demo Model',
        SerialNumber: 'SN' + Math.floor(Math.random() * 10000),
        ImageWidth: this.field.imageWidth,
        ImageHeight: this.field.imageHeight,
        ImageDPI: 500,
        ImageQuality: 85,
        NFIQ: 2,
      }

      // Update our component data
      this.fingerprintData = mockData
      this.fingerprintImageUrl = `data:image/bmp;base64,${mockData.BMPBase64}`
      this.hasFingerprint = true
      this.isCapturing = false

      // Update the field value
      this.updateFieldValue()

      this.log('Fingerprint data updated')
    },

    updateFieldValue() {
      // Depending on the configuration, we might want to store just the template or all data
      // For this implementation, we'll store all data
      this.$emit('input', this.fingerprintData)
    },

    createMockBMP() {
      // In a real implementation, this would be a base64 encoded BMP from the scanner
      // For demo purposes, we'll create a simple pattern

      // Create a canvas to generate the BMP
      const canvas = document.createElement('canvas')
      canvas.width = this.field.imageWidth
      canvas.height = this.field.imageHeight
      const ctx = canvas.getContext('2d')

      // Fill with a gradient
      const gradient = ctx.createRadialGradient(
        canvas.width / 2,
        canvas.height / 2,
        0,
        canvas.width / 2,
        canvas.height / 2,
        canvas.width / 2
      )
      gradient.addColorStop(0, '#666')
      gradient.addColorStop(1, '#222')
      ctx.fillStyle = gradient
      ctx.fillRect(0, 0, canvas.width, canvas.height)

      // Draw fingerprint-like pattern
      ctx.strokeStyle = '#888'
      ctx.lineWidth = 1

      for (let i = 0; i < 30; i++) {
        ctx.beginPath()
        ctx.ellipse(
          canvas.width / 2,
          canvas.height / 2,
          canvas.width / 3 - i * 3,
          canvas.height / 2 - i * 3,
          0,
          0,
          Math.PI * 2
        )
        ctx.stroke()
      }

      // Add some noise
      const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height)
      const data = imageData.data

      for (let i = 0; i < data.length; i += 4) {
        const noise = Math.random() * 20 - 10
        data[i] = Math.max(0, Math.min(255, data[i] + noise))
        data[i+1] = Math.max(0, Math.min(255, data[i+1] + noise))
        data[i+2] = Math.max(0, Math.min(255, data[i+2] + noise))
      }

      ctx.putImageData(imageData, 0, 0)

      // Return base64 data
      return canvas.toDataURL('image/png').split(',')[1]
    }
  }
}
</script>

<style>
.fingerprint-field {
  margin-bottom: 1rem;
}

.scanner-animation {
  position: relative;
  overflow: hidden;
  background-color: #f1f1f1;
}

.scanner-line {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 2px;
  background-color: #4099de;
  box-shadow: 0 0 8px rgba(64, 153, 222, 0.8);
  animation: scan 2s linear infinite;
}

@keyframes scan {
  0% {
    top: 0;
  }
  50% {
    top: 100%;
  }
  50.1% {
    top: 100%;
  }
  100% {
    top: 0;
  }
}
</style>