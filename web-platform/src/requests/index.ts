import axios from "axios";

class Requests {
    public res: any;
    
    async get(url: string, body: any) {
        this.res = await axios.get(url, {
            params: body
        });
    }

    async post(url: string, body: any) {
        this.res = await axios.post(url, body);
    }
}

export default Requests;