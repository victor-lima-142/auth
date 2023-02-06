const endpoints = {
    auth: {
        verifyUser: '/auth/verifyUser',
        verifyPassword: '/auth/verifyPassword',
        register: '/auth/register',
        logout: '/auth/logout',
        edit: '/auth/edit',
        find: '/auth/find',
        resetPassword: '/auth/resetPassword',
        delete: '/auth/delete',
        sendValidCodePass: '/auth/sendValidCodePass',
        checkCode: '/auth/checkCode',
        resetForgotPassword: '/auth/resetForgotPassword'
    }
}

export default endpoints;