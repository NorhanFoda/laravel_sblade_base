const components = import.meta.glob(['./*','./form/*'], { eager: true })
const register = (app) => {
    Object.entries(components).forEach(([path, definition]) => {
        // Get name of component, based on filename
        // "./components/Fruits.vue" will become "Fruits"
        const componentName = path.split('/').pop().replace(/\.\w+$/, '')
        // Register component on this Vue instance
        app.component(componentName, definition.default)
    })
};

export default {
    register,
};
