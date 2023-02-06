import { FormControl, Button, Form } from 'react-bootstrap';

const Register = (props: any) => {
    const { _setAuthMode, username, _setUsername, email, _setEmail, password, _setPassword, register } = props;
    return <>
        <h1>Register</h1>
        <Form onSubmit={(event) => event.preventDefault()}>
            <FormControl type='text' placeholder='username' value={username} onChange={_setUsername} />
            <FormControl type='text' placeholder='email' value={email} onChange={_setEmail} />
            <FormControl type='password' placeholder='password' value={password} onChange={_setPassword} />
            <section className='w-100 mb-2'>
                <Button variant='dark' type='submit' className='shadow' onClick={register}>Send</Button>
            </section>
            <span onClick={_setAuthMode}>Login here</span>
        </Form>
    </>
}

export default Register;