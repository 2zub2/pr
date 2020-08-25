<template>
    <div>
        <a-button type="primary"
                  @click="requestNewRandom"
                  :disabled="loading"
                  style="margin-bottom: 20px;"
        >
            Вырастить яблоки
        </a-button>

        <a-table
                :rowKey="record => record.id"
                :columns="columns"
                :dataSource="apples"
                :loading="loading"
        >
            <span slot="action" slot-scope="text, record">
                <a @click="() => fallToGround(record.id)"
                >
                    упасть
                </a>
                <a-divider type="vertical" />
                <a-popover title="укажите процент" trigger="click" :visible="popupRecId === record.id">
                    <template slot="content">
                        <a-input-number
                                style="display: block; margin-bottom: 10px;"
                                :defaultValue="0"
                                :min="0"
                                :max="100"
                                :formatter="value => `${value}%`"
                                :parser="value => value.replace('%', '')"
                                @change="onChangePercent"
                        />
                        <a @click="() => eat(record.id, )">съесть</a>
                        <a @click="popupRecId = 0">закрыть</a>
                    </template>

                    <a @click="popupRecId = record.id"
                    >
                        съесть</a>
                </a-popover>

            </span>
        </a-table>
    </div>


</template>

<script>
    import Vue from 'vue';
    import Antd from 'ant-design-vue';
    import axios from 'axios';

    Vue.use(Antd);

    const columns = [
        {
            title: 'цвет',
            dataIndex: 'color',
        },
        {
            title: 'выросло',
            dataIndex: 'grown_date',
        },
        {
            title: 'состояние',
            dataIndex: 'state',
        },
        {
            title: 'размер от целого',
            dataIndex: 'size',
        },
        {
            title: 'дата падения',
            dataIndex: 'falling_date',
        },
        {
            title: 'действия',
            key: 'action',
            scopedSlots: { customRender: 'action' },
        },
    ];

    export default {
        name: "Apples",
        data() {
            return {
                loading: false,
                apples: [],
                generateNum: 1,
                popupRecId: 0,
                percent: 0,

                columns,
            }
        },
        created: function () {
            console.log('created');
            this.$notification.config({
                placement: 'topRight',
            });
            this.requestApple();
        },
        methods: {
            init(params) {
                for (const prop in params) {
                    if (params.hasOwnProperty(prop) && this.hasOwnProperty(prop)) {
                        this[prop] = params[prop];
                        console.log(prop, params[prop]);
                    }
                }
            },
            requestApple() {
                this.loading = true;

                this.apples = [];

                axios({
                    method: 'get',
                    url: 'apple/apples',
                    responseType: 'json',
                    headers: { 'common' : { 'X-Requested-With' : 'XMLHttpRequest'} }
                })
                .then((response) => {
                    this.init(response.data);
                })
                .catch((error) => {
                    console.log('error', error);
                    this.showErrorMessage(error);
                }).then(() => {
                    this.loading = false;
                });
            },
            requestNewRandom() {
                this.loading = true;

                axios({
                    method: 'get',
                    url: 'apple/create-random',
                    responseType: 'json',
                    headers: { 'common' : { 'X-Requested-With' : 'XMLHttpRequest'} }
                })
                .then((response) => {
                    this.init(response.data);
                })
                .catch((error) => {
                    console.log('error', error);
                    this.showErrorMessage(error);
                }).then(() => {
                    this.loading = false;
                });
            },
            updateApple(data, id) {
                const newApples = [...this.apples];
                const target = newApples.filter(item => item.id === id)[0];

                if (target && data) {
                    Object.assign(target, data);
                    this.data = newApples;
                } else {
                    throw 'произошла ошибка';
                }
            },
            fallToGround(id) {
                axios({
                    method: 'get',
                    url: 'apple/fall-to-ground',
                    params: {
                        id: id,
                    },
                    responseType: 'json',
                    headers: { 'common' : { 'X-Requested-With' : 'XMLHttpRequest'} }
                })
                .then((response) => {
                    const { data } = response;
                    this.updateApple(data, id);
                })
                .catch((error) => {
                    console.log('error', error);
                    this.showErrorMessage(error);
                }).then(() => {
                    this.loading = false;
                });
            },
            eat(id) {
                axios({
                    method: 'get',
                    url: 'apple/eat',
                    params: {
                        id: id,
                        percent: this.percent,
                    },
                    responseType: 'json',
                    headers: { 'common' : { 'X-Requested-With' : 'XMLHttpRequest'} }
                })
                .then((response) => {
                    const { data } = response;
                    this.updateApple(data, id);
                    this.popupRecId = 0;
                })
                .catch((error) => {
                    console.log('error', error);
                    this.showErrorMessage(error);
                }).then(() => {
                    this.loading = false;
                });
            },
            onChangePercent(value) {
                this.percent = value;
            },
            showErrorMessage(error) {
                const { response } = error;
                let message = '';
                if (response) {
                    message = error.response.data ? error.response.data.message : error.response.statusText;
                }

                this.$notification.error({
                    message: 'ошибка',
                    description: message ? message : 'не известная ошибка',
                    duration: 0,
                });
            },
        }
    }
</script>

<style>
    .ant-notification {
        z-index: 2000;
    }
</style>