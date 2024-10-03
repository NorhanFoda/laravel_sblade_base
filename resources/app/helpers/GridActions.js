export const GridActions = {
    afterCreate(resources, model) {
        resources.unshift(model);
    },
    afterUpdate(resources, model) {
        let index = resources.findIndex((item) => item.id === model.id);
        resources[index] = model;
    },
    afterDelete(resources, index) {
        resources.splice(index, 1);
    }
}
