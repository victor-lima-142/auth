import "./global.scss"
import { Router } from './components';
import { useNavigate, useLocation } from 'react-router-dom';
import { Navigation } from "./components";
import React from "react";
import { getItem } from "./config/storage";

const App = (): JSX.Element => {
    const navigate = useNavigate();
    const location = useLocation();
    const [currentPath, setCurrentPath] = React.useState<string | null>(null);
    const [logged, setLogged] = React.useState<boolean>(false);
    const [loading, setLoading] = React.useState<boolean>(false);
    const _setLogged = () => setLogged(logged ? false : true);

    React.useEffect(() => {
        setCurrentPath(location.pathname.replace('/', ''));
        if (getItem('userData')) {
            setLogged(true);
        } else {
            setLogged(false);
        }
    }, [location]);


    if (currentPath === null)
        return <></>;

    return <>
        <Navigation {...{ navigate, location, logged, _setLogged, loading, setLoading }} />
        <main className={currentPath === '' ? "" : "pt-4 mt-5"}>
            <Router {...{ navigate, location, logged, _setLogged, loading, setLoading }} />
        </main>
    </>;
}



export default App;
