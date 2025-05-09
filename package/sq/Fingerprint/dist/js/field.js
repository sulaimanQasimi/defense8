/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({
/***/ "./src/resources/js/components/FingerprintField.vue":
/*!**********************************************************!*\
  !*** ./src/resources/js/components/FingerprintField.vue ***!
  \**********************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {
  __webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, { "default": () => (__WEBPACK_DEFAULT_EXPORT__) });
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
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
        return 'mockBase64Data'
      }
    },
    template: `
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
                  :style="\`max-width: \${field.imageWidth}px; max-height: \${field.imageHeight}px;\`"
                />
                <div v-else class="mb-3 flex items-center justify-center border border-gray-300 dark:border-gray-700 rounded" :style="\`width: \${field.imageWidth}px; height: \${field.imageHeight}px;\`">
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
                <div class="scanner-animation mb-3 flex items-center justify-center border border-gray-300 dark:border-gray-700 rounded" :style="\`width: \${field.imageWidth}px; height: \${field.imageHeight}px;\`">
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
    `
});
/***/ }),

/***/ "./src/resources/js/field/index.js":
/*!*****************************************!*\
  !*** ./src/resources/js/field/index.js ***!
  \*****************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_FingerprintField__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/FingerprintField */ "./src/resources/js/components/FingerprintField.vue");


Nova.booting((app, store) => {
  app.component('fingerprint-field', _components_FingerprintField__WEBPACK_IMPORTED_MODULE_0__["default"])
})

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/************************************************************************/
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!*****************************************!*\
  !*** ./src/resources/js/field/index.js ***!
  \*****************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _components_FingerprintField__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/FingerprintField */ "./src/resources/js/components/FingerprintField.vue");


Nova.booting((app, store) => {
  app.component('fingerprint-field', _components_FingerprintField__WEBPACK_IMPORTED_MODULE_0__["default"])
})
})();

/******/ })()
;
