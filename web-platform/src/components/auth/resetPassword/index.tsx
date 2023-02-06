import React from 'react';
import { Button, Form } from 'react-bootstrap';
import AuthRequests from '../../../requests/auth';

const ResetPassword = (props: any) => {
    const { _setAuthMode, email, _setEmail } = props;
    const [code, setCode] = React.useState<string>('');
    const [codeSent, setCodeSent] = React.useState<boolean>(false);

    const sendCode = async () => {
        const authRequests = new AuthRequests();
        const res = await authRequests.sendValidCodePass({ email: email });
        setCodeSent(false);
        console.log(res);
    }

    const _setCode = (event: any) => setCode(event?.target.value)

    return <>
        <h1>Reset Password</h1>
        <Form onSubmit={() => void (0)}>
            <Form.Group className="mb-3">
                <Form.Control type="email" placeholder="Email" value={email} onChange={_setEmail} />
            </Form.Group>

            {codeSent &&
                <Form.Group className="mb-3">
                    <Form.Control type="number" placeholder="Password" value={code} onChange={_setCode} className='mb-0' />
                </Form.Group>
            }

            <section className='w-100 mb-2'>
                <Button variant='dark' type='button' className='shadow' onClick={sendCode}>Send code</Button>
            </section>
        </Form>
    </>
}

export default ResetPassword;