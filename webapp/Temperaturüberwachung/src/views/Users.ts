import {getApp} from "../helpers/Container.ts";

const getTemplate = () => {
    return "<h1>Users</h1>";
}

class Users {
    async init() {
        const app = getApp();

        app.innerHTML = getTemplate();
    }
}

export default new Users();