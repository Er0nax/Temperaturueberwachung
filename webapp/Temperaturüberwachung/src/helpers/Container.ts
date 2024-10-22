export const getApp = () => {
    const app = document.getElementById('app');

    if (!app) {
        throw "Could not find the app container.";
    }

    return app;
}