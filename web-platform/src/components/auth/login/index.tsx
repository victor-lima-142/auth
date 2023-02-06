import { Button, Form } from 'react-bootstrap';

const Login = (props: any) => {
    const { _setAuthMode, username, _setUsername, login, password, _setPassword, setAuthMode } = props;

    const forgotMyPass = () => setAuthMode('resetPassword');

    return <>
        <h1>Login</h1>
        <Form onSubmit={() => void (0)}>
            <Form.Group className="mb-3">
                <Form.Control type="email" placeholder="Username or email" value={username} onChange={_setUsername} />
            </Form.Group>

            <Form.Group className="mb-3">
                <Form.Control type="password" placeholder="Password" value={password} onChange={_setPassword} className='mb-0' />
                <Form.Text className="text-muted m-0" style={{ cursor: 'pointer' }} onClick={forgotMyPass}>
                    I forgot my password
                </Form.Text>
            </Form.Group>
            <section className='w-100 mb-2'>
                <Button variant='dark' type='button' className='shadow' onClick={login}>Send</Button>
            </section>
            <span className='mt-2' onClick={_setAuthMode}>Register here</span>
        </Form>
    </>
}


export default Login;