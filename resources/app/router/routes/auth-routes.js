import Login from "@views/auth/Login.vue";
import i18n from "../../lang";

const t = () => i18n;
export default [
    {
        path: "/login",
        name: "login",
        component: Login,
        meta: {
            requiresAuth: true,
            title: t("messages.login"),
        },
    }
];
