
export const clearStorage = () => {
    sessionStorage.clear();
}

export const logout = (reloadPage: boolean = false) => {
    clearStorage();

    if (reloadPage) {
        window.location.reload();
    }
}

export const removeItem = (key: string) => {
    if (key)
        sessionStorage.removeItem(key);
}

export const setItem = (key: string, value: any) => {
    if (key && value)
        sessionStorage.setItem(key, JSON.stringify(value));
}

export const getItem = (key: string) => {
    try {
        if (key) {
            const value = sessionStorage.getItem(key) || '';
            if (value)
                return JSON.parse(value);
            return '';
        };
        return '';
    } catch (e) {
        // console.log(`storage-service => getItem => key '${key}' => error:`, e);
        logout();
    }
}