import axios from "axios";
import { getItem } from "../config/storage";

class Requests {
    public res: any;

    async get(url: string, body: any = {}) {
        const userData = getItem("userData");
        let parms = {};
        if (userData) parms = { ...parms, ...{ user: userData?.user, token: userData?.token } };
        this.res = await axios.get(url, { params: { ...parms, ...body } });
    }

    async post(url: string, body: any = {}) {
        const userData = getItem("userData");
        let parms = {};
        if (userData) parms = { ...parms, ...{ user: userData?.user, token: userData?.token } };
        this.res = await axios.post(url, { ...parms, ...body });
    }
}

export default Requests;