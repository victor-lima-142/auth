import Requests from ".";
import endpoints from "./endpoints";

class AuthRequests extends Requests {
    async verifyUser(body?: any) {
        await this.post(endpoints.auth.verifyUser, body);
        return this.res;
    }

    async verifyPassword(body?: any) {
        await this.post(endpoints.auth.verifyPassword, body);
        return this.res;
    }

    async register(body?: any) {
        await this.post(endpoints.auth.register, body);
        return this.res;
    }

    async logout(body?: any) {
        await this.post(endpoints.auth.logout, body);
        return this.res;
    }

    async sendValidCodePass(body?: any) {
        await this.post(endpoints.auth.sendValidCodePass, body);
        return this.res;
    }

    async checkCodePass(body?: any) {
        await this.post(endpoints.auth.checkCode, body);
        return this.res;
    }

    async resetForgotPassword(body?: any) {
        await this.post(endpoints.auth.resetForgotPassword, body);
        return this.res;
    }
}

export default AuthRequests;