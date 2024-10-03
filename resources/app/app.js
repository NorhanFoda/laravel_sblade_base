import './bootstrap';
import {createApp} from 'vue';

import App from "@/App.vue";
import router from "@/router";
import store from "@/store";
import i18n from "@/lang";

import MainPlugin from "@/plugins";
import BaseComponents from '@/components';

import CKEditor from '@ckeditor/ckeditor5-vue';

const app = createApp(App);
//mixins
app.mixin({
    data() {
        return {
            publicPath: import.meta.env.VITE_VUE_APP_ROOT + '/UI',
            publicUrl: import.meta.env.VITE_VUE_APP_ROOT,
        }
    }
});
//registered components
BaseComponents.register(app);
//state management with pinia
app.use(store);
//app plugins
app.use(i18n);
app.use(MainPlugin);
app.use(router);
app.use(CKEditor);
app.mount('#app');
