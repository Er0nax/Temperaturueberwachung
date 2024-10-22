import {getRoute} from "../helpers/Routes.ts";
import Sensors from "../views/Sensors.ts";
import Home from "../views/Home.ts";
import Users from "../views/Users.ts";

export const initRouter = async () => {
    const route = getRoute();

    switch (route) {
        case 'sensors':
            await Sensors.init();
            break;

        case 'users':
            await Users.init();
            break;

        case 'index':
        default:
            await Home.init();
            break;
    }
}