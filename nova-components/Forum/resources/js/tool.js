import Tool from './pages/Tool'
import Category from './pages/Category'
import Thread from './pages/Thread'

import camelCase from 'lodash/camelCase'
import upperFirst from 'lodash/upperFirst'
import { createApp, defineComponent } from 'vue';
import ForumMenuIcon from "./components/ForumMenuIcon";
Nova.booting((app, store) => {
    Nova.inertia('Forum', Tool)
    Nova.inertia('Category', Category)
    Nova.inertia('Thread', Thread)

    const requireComponent = require.context(
        './components',
        true,
        /[A-Z]\w+\.(vue)$/
    )

    requireComponent.keys().forEach(fileName => {
        const componentConfig = requireComponent(fileName)

        const componentName =
            upperFirst(
                camelCase(
                    fileName
                        .split('/')
                        .pop()
                        .replace(/\.\w+$/, '')
                )
            )
        app.component(componentName, componentConfig.default || componentConfig)
    })



    window.addEventListener('DOMContentLoaded', () => {
        let appHeader = document.getElementsByTagName('header');

        if (appHeader.length > 0) {
            let MenuIcon = defineComponent({
                extends: ForumMenuIcon,
            })

            let lang = document.createElement('div');
            lang.className = 'mr-3';
            let newApp = createApp(MenuIcon);
            newApp.mount(lang);
            appHeader[0].lastChild.lastChild.insertBefore(lang, appHeader[0].lastChild.lastChild.firstChild);
        }
    })

})
