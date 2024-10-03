import ability from "./ability"
import ElementPlus from './elementPlus'

export default {
    install: (app, options) => {
        app.use(ability);
        app.use(ElementPlus);
    }
}
