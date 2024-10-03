import BaseApi from "./base.api"
import Http from "@services/http"

export default class UserApi extends BaseApi {

    static get entity() {
        return 'users'
    }
    static async me(params = {}) {
        return await Http.get('me', params)
    }

    static async changePassword(params = {}) {
        return await Http.post('change-password', params)
    }

    static async getAttachmentsTypes() {
        return await Http.get(this.entity + '/filters/attachments-types')
    }
    
}
