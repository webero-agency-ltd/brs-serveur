import Vue from 'vue';

//importation des composante B 
import bListe from '../components/b/liste';
Vue.component('b-liste', bListe);

import bFormItem from '../components/b/form-item';
Vue.component('b-form-item', bFormItem);

import bForm from '../components/b/form';
Vue.component('b-form', bForm);

///////////////////////////////////////////
// Importation de l'applications  
//////////////////////////////////////////
import admin from '../application/admin';
Vue.component('app-admin', admin);

import adminMenu from '../components/admin/menu';
Vue.component('admin-menu', adminMenu);

import adminSidebar from '../components/admin/sidebar';
Vue.component('admin-sidebar', adminSidebar);

///////////////////////////////////////////
// Composante 
//////////////////////////////////////////
import modal from '../components/modal';
Vue.component('modal', modal);

import { 
	Menu , 
	Avatar , 
	Layout , 
	Breadcrumb , 
	Col , 
	Row , 
	Button , 
	Table ,
	Modal ,
	Input , 
	Card , 
	Icon , 
	Divider , 
	Form ,
	Radio , 
	Popover , 
	Drawer ,
	Badge ,
	Comment , 
	Tooltip , 
	Spin , 
	List , 
	Alert , 
	Tabs ,
	Select , 
	DatePicker ,
	InputNumber , 
	Progress , 
} from 'ant-design-vue';

Vue.component( Menu.name, Menu );
Vue.component( Menu.Item.name, Menu.Item );
Vue.component( Menu.SubMenu.name, Menu.SubMenu );

Vue.component( Avatar.name, Avatar );

Vue.component( Layout.name, Layout );
Vue.component( Layout.Header.name, Layout.Header );
Vue.component( Layout.Content.name, Layout.Content );
Vue.component( Layout.Sider.name, Layout.Sider );

Vue.component( Row.name, Row );
Vue.component( Col.name, Col );

Vue.component( Breadcrumb.name, Breadcrumb );

Vue.component( Button.name, Button );
Vue.component( Button.Group.name, Button.Group );

Vue.component( Table.name, Table );

Vue.component( Modal.name, Modal );

Vue.component( Input.name, Input );
Vue.component( Input.TextArea.name, Input.TextArea );

Vue.component( Tooltip.name, Tooltip );

Vue.component( Card.name, Card );
Vue.component( Card.Meta.name, Card.Meta );
Vue.component( Card.Grid.name, Card.Grid );

Vue.component( Icon.name, Icon );

Vue.component( Divider.name, Divider );

Vue.component( Form.name, Form );
Vue.component( Form.Item.name, Form.Item );

Vue.component( Radio.name, Radio );
Vue.component( Radio.Button.name, Radio.Button );
Vue.component( Radio.Group.name, Radio.Group );

Vue.component( Popover.name, Popover );

Vue.component( Drawer.name, Drawer );

Vue.component( Badge.name, Badge );

Vue.component( Comment.name, Comment );

Vue.component( Spin.name, Spin );

Vue.component( List.name, List );
Vue.component( List.Item.name, List.Item );
Vue.component( List.Item.Meta.name, List.Item.Meta );

Vue.component( Alert.name, Alert );

Vue.component( Tabs.name, Tabs );
Vue.component( Tabs.TabPane.name, Tabs.TabPane );

Vue.component( Select.name, Select );
Vue.component( Select.Option.name, Select.Option );

Vue.component( DatePicker.name, DatePicker );

Vue.component( InputNumber.name, InputNumber );

Vue.component( Progress.name, Progress );

//page trasition
import VuePageTransition from 'vue-page-transition'
Vue.use(VuePageTransition)

let comp = {}

export default comp;