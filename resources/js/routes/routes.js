import Index from '../views/panel/Index'
import User from '../views/panel/User'
import NotFound from '../views/panel/NotFound'
import SettingApplication from '../views/panel/SettingApplication'
import SettingComment from '../views/panel/SettingComment'
import SettingColor from '../views/panel/SettingColor'
import Category from '../views/panel/Category'
import UserDetail from '../views/panel/UserDetail'
import CategoryComment from '../views/panel/CategoryComment'
import CategorySpecification from '../views/panel/CategorySpecification'
import Comment from '../views/panel/Comment'
import Discuss from '../views/panel/Discuss'

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
        path: '/setting/color',
        name: 'SettingColor',
        component: SettingColor
    },
    {
        path: '/category',
        name: 'Category',
        component: Category
    },
    {
        path: '/category/getComments/:id',
        name: 'CategoryComment',
        component: CategoryComment
    },
    {
        path: '/category/getSpecifications/:id',
        name: 'CategorySpecification',
        component: CategorySpecification
    },
    {
        path: '/comment',
        name: 'Comment',
        component: Comment
    },
    {
        path: '/discuss',
        name: 'Discuss',
        component: Discuss
    },
]
