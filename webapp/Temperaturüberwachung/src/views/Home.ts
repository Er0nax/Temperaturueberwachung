import {getApp} from "../helpers/Container.ts";

const getTemplate = () => {
    return "<h1>Home</h1>";
}

class Home {
    async init() {
        const app = getApp();

        app.innerHTML = getTemplate();
    }
}

export default new Home();