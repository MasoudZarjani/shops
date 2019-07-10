import Index from '../views/panel/Index'
import User from '../views/panel/User'
import NotFound from '../views/panel/NotFound'
import Setting from '../views/panel/Setting'
import Category from '../views/panel/Category'

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
    },
    {
        path: '/setting',
        name: 'تنظیمات',
        component: Setting
    },
    {
        path: '/category',
        name: 'دسته بندی',
        component: Category
    }
]
