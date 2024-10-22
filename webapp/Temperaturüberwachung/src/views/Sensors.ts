import {getApp} from "../helpers/Container.ts";

const getTemplate = () => {
    return "<h1>Sensors</h1>";
}

class Sensors {
    async init() {
        const app = getApp();

        app.innerHTML = getTemplate();
    }
}

export default new Sensors();