import BaseApi from "./base.api";

export default class FileApi extends BaseApi {
    static get entity() {
        return 'files'
    }
}
