import Index from '../views/panel/Index'
import User from '../views/panel/User'
import NotFound from '../views/panel/NotFound'
import SettingApplication from '../views/panel/SettingApplication'
import SettingComment from '../views/panel/SettingComment'
import Color from '../views/panel/Color'
import Category from '../views/panel/Category'
import UserDetail from '../views/panel/UserDetail'
import CategoryComments from '../views/panel/CategoryComments'
import Comment from '../views/panel/Message'

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
        path: '/setting/application',
        name: 'SettingApplication',
        component: SettingApplication
    },
    {
        path: '/setting/comment',
        name: 'SettingComment',
        component: SettingComment
    },
    {
        path: '/category',
        name: 'Category',
        component: Category
    },
    {
        path: '/category/getComments/:id',
        name: 'CategoryComments',
        component: CategoryComments
    },
    {
        path: '/color',
        name: 'Color',
        component: Color
    },
    {
        path: '/comment',
        name: 'Comment',
        component: Comment
    },
]
