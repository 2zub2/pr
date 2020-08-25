import "core-js/stable";
import "regenerator-runtime/runtime";

import Vue from 'vue';
import Apples from './Apples';
import ruRU from 'ant-design-vue/lib/locale-provider/ru_RU';

new Vue({
    el: '#apples',
    components: { Apples },
    template: '<a-locale-provider :locale="locale"><Apples/></a-locale-provider>',
    data() {
        return {
            locale: ruRU,
        };
    },
});