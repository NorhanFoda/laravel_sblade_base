import {
    createRouter,
    createWebHistory
} from "vue-router";

import routes from "@/router/routes";

import {checkAccessMiddleware} from './middlewares/checkAccessMiddleware';

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(checkAccessMiddleware);

export default router
