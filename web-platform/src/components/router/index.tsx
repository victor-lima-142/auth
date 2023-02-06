import { Route } from 'react-router';
import { Routes } from "react-router-dom"
import { Auth, Home } from '../../pages';

const MyRouter = (props: any) => {
    return <>
        <Routes>
            <Route path='/login' element={<Auth { ...props} />} />
            <Route path='/' element={<Home { ...props } />} />
        </Routes>
    </>
}

export default MyRouter;