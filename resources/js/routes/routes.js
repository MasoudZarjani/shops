import Index from '../views/panel/Index'
import User from '../views/panel/User'
import NotFound from '../views/panel/NotFound'

export default [{
        path: '*',
        name: 'صفحه پیدا نشد',
        component: NotFound
    },
    {
        path: '/',
        name: 'صفحه اصلی',
        component: Index
    },
    {
        path: '/user',
        name: 'کاربران',
        component: User
    }
]
