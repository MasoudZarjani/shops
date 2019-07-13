import Index from '../views/panel/Index'
import User from '../views/panel/User'
import NotFound from '../views/panel/NotFound'
import Setting from '../views/panel/Setting'
import Category from '../views/panel/Category'
import UserDetail from '../views/panel/UserDetail'

export default [{
        path: '*',
        name: 'NotFound',
        component: NotFound
    },
    {
        path: '/',
        name: 'Index',
        component: Index
    },
    {
        path: '/user',
        name: 'User',
        component: User
    },
    {
        path: '/user/detail/:id',
        name: 'UserDetail',
        component: UserDetail
    },
    {
        path: '/setting',
        name: 'Setting',
        component: Setting
    },
    {
        path: '/category',
        name: 'Category',
        component: Category
    },

]
