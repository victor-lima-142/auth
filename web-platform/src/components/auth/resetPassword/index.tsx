import React from 'react';
import { Button, Form } from 'react-bootstrap';
import AuthRequests from '../../../requests/auth';
import Loader from '../../loader';

const ResetPassword = (props: any) => {
    const { email, _setEmail, loading, setLoading, setAuthMode } = props;
    const [code, setCode] = React.useState<string>('');
    const [newPassword, setNewPassword] = React.useState<string>('');
    const [verified, setVerified] = React.useState<boolean>(false);
    const [codeSent, setCodeSent] = React.useState<boolean>(false);

    const _setNewPassword = (event: any) => setNewPassword(event?.target?.value);

    const onHandleClick = () => {
        if (verified) {
            resetForgotPassword();
        } else {
            if (codeSent) {
                checkCode();
            } else {
                sendCode();
            }
        }
    }

    const sendCode = async () => {
        try {
            setLoading(true);
            const authRequests = new AuthRequests();
            const res = await authRequests.sendValidCodePass({ email: email });

            if (res?.status === 200) {
                alert("Código enviado");
                setCodeSent(true);
            }
        } catch (e: any) {
            console.log(e);
        } finally {
            setLoading(false);
        }
    }

    const checkCode = async () => {
        try {
            setLoading(true);
            const authRequests = new AuthRequests();
            const res = await authRequests.checkCodePass({ email, code });
            if (res?.status === 200) {
                if (res?.data?.valid) {
                    setVerified(true);
                    alert('código válido');
                } else {
                    alert('código inválido');
                }
            }
        } catch (e: any) {
            console.log(e);
        } finally {
            setLoading(false);
        }
    }

    const resetForgotPassword = async () => {
        try {
            setLoading(true);
            const authRequests = new AuthRequests();
            const res = await authRequests.resetForgotPassword({ email, newPassword });
            if (res?.status === 200) {
                alert('senha atualizada');
                setAuthMode('login');
            }
        } catch (e: any) {
            console.log(e);
        } finally {
            setLoading(false);
        }
    }

    const _setCode = (event: any) => setCode(event?.target.value)

    return <>
        <h1>Reset Password</h1>
        <Form onSubmit={() => void (0)}>
            <Form.Group className="mb-3">
                <Form.Control type="email" disabled={codeSent} placeholder="Email" value={email} className='mb-0 text-center' onChange={_setEmail} />
            </Form.Group>

            {codeSent &&
                <Form.Group className="mb-3">
                    <Form.Control type="text" placeholder="Code" disabled={verified} value={code} onChange={_setCode} className='mb-0 text-center' />
                </Form.Group>
            }

            {verified &&
                <Form.Group className="mb-3">
                    <Form.Control type="password" placeholder="Password" value={newPassword} onChange={_setNewPassword} className='mb-0 text-center' />
                </Form.Group>
            }

            <section className='w-100 mb-2'>
                <Button variant='dark' type='button' className='shadow' onClick={onHandleClick}>
                    {loading && <Loader />}
                    {(!loading && codeSent) && 'Verify Code'}
                    {(!loading && !codeSent) && 'Send Code'}
                </Button>
            </section>
        </Form>
    </>
}

export default ResetPassword;