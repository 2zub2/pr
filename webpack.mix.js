let mix = require('laravel-mix');

mix.less('node_modules/ant-design-vue/dist/antd.less', 'backend/assets/src/css', {
       javascriptEnabled: true,
});

mix.js('backend/src/apples-main.js', 'backend/assets/src/js/');
