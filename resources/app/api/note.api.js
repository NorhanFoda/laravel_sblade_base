import Http from "@services/http";
import BaseApi from "@api/base.api";
export default class NoteApi extends BaseApi {
    static get entity() {
        return 'notes'
    }
}
