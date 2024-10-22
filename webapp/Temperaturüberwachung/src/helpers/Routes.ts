export const getRoute = (includeQueryAndHash: boolean = false) => {

    if (includeQueryAndHash) {
        return window.location.href.replace(window.location.origin, '');
    }

    return window.location.pathname.replace(/^\/+/, '');
}

export const getContent = async (fileName: string) => {
    try {
        const response = await fetch(`/${fileName}`);

        if (!response.ok) {
            console.error(`Failed to load the file: ${response.statusText}`);
            return "";
        }

        return await response.text();
    } catch (error) {
        console.error("Error reading the HTML file:", error);
        return "";
    }
}