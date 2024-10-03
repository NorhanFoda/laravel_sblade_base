import {useAuthUserStore} from "@/store/user"

export default class User {
    static isLogged() {
        const store = useAuthUserStore()
        return !!store.user.id
    }
}
