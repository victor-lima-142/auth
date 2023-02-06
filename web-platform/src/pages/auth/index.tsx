import React from "react";
import { Login, Register, ResetPassword } from "../../components";
import { Col } from "react-bootstrap";
import "./auth.scss";
import AuthRequests from "../../requests/auth";
import { setItem } from "../../config/storage";

const Auth = (props: any): JSX.Element => {
    const { navigate, _setLogged, setLoading } = props;

    const [username, setUsername] = React.useState<string>('');
    const [email, setEmail] = React.useState<string>('');
    const [password, setPassword] = React.useState<string>('');
    const [authMode, setAuthMode] = React.useState<string | null>('login');

    const authRequests = new AuthRequests();

    const _setUsername = (event: any): void => setUsername(event?.target.value);
    const _setEmail = (event: any): void => setEmail(event?.target.value);
    const _setPassword = (event: any): void => setPassword(event?.target.value);
    const _setAuthMode = (): void => {
        setAuthMode(authMode === null || authMode === 'register' ? 'login' : 'register');
    }

    const login = async (event?: any) => {
        event?.preventDefault();
        try {
            setLoading(true);
            const resUser = await authRequests.verifyUser({ username: username, email: username });
            if (resUser?.status !== 200) return;
            const resPass = await authRequests.verifyPassword({ user: resUser?.data?.user, password: password });
            if (resPass?.status !== 200) return;

            setItem('userData', resPass?.data);
            _setLogged(true);
            navigate('/');
        } catch (e: any) {
            console.log(e);
        } finally {
            setLoading(false);
        }
    }

    const register = async (event: any) => {
        event?.preventDefault();
        try {
            setLoading(true);
            const res = await authRequests.register({ username: username, email: email, password: password, level: 0 });
            if (res?.status === 200) {
                login();
            } else {
                console.log('error', [res, res?.data]);
            }
        }
        catch (e: any) {
            console.log(e);
        } finally {
            setLoading(false);
        }
    }

    if (authMode === null) return <></>;

    return <Col className="shadow form-auth">
        {(authMode === 'login') && <Login {...props} {...{ _setAuthMode, username, _setUsername, password, _setPassword, login, setAuthMode }} />}
        {(authMode === 'register') && <Register {...props} {...{ _setAuthMode, username, _setUsername, email, _setEmail, password, _setPassword, register }} />}
        {(authMode === 'resetPassword') && <ResetPassword {...props} {...{ setAuthMode, username, _setUsername, email, _setEmail, password, _setPassword, register }} />}
    </Col>
}

export default Auth;