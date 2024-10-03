import {useAuthUserStore} from "@store/user";

export default {
    methods: {
        hasRole(role){
            return useAuthUserStore().hasRole(role)
        },
        hasPermission(action, module){
            return useAuthUserStore().hasPermission(action, module)
        }
    }
}
