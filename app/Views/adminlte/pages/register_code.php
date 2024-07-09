<?= $this->extend("adminlte/layouts/basic") ?>

<?= $this->section("content") ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="text-center fw-light">Search by Code</h1>
            </div>
        </div>
    </div>
</section>

<section class="content" id="user-box">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ data.user }}</h3>
                        <p>User Registrations</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ data.rate }}<sup style="font-size: 20px">%</sup></h3>
                        <p>Deposited Rate ({{ data.deposited }} User)</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ data.avg }}</h3>
                        <p>Average Deposit/User</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ data.total }}</h3>
                        <p>First Deposit Total</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-cash"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="d-flex flex-row gap-3">
                                    <div class="d-flex flex-row align-items-baseline">
                                        <label class="me-1" for="end_date" style="width: 110px;">Channels: </label>
                                        <select class="form-select" v-model="form.code" @change="search_data">
                                            <option value="">No Channel</option>
                                            <option v-for="channel in data.channels" :value="channel.ref">{{channel.name}}</option>
                                        </select>
                                    </div>
                                    <div class="d-flex flex-row align-items-baseline">
                                        <label class="me-1" for="start_date">Start: </label>
                                        <input id="start_date" type="date" class="form-control" v-model="form.s_date" @change="search_data">
                                    </div>
                                    <div class="d-flex flex-row align-items-baseline">
                                        <label class="me-1" for="end_date">End: </label>
                                        <input id="end_date" type="date" class="form-control" v-model="form.e_date" @change="search_data">
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <input type="search" class="form-control" placeholder="Search" v-model="filter" @input="filter_user">
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <template v-if="table.filtered.length">
                            <Datatable class="table table-striped" :value="table.filtered" :size="`small`" paginator :rows="rows.perpage">
                                <Column :exportable="false" style="width:4rem">
                                    <template #body="{data}">
                                        <button type="button" class="btn btn-xs btn-success" @click="view_detail(data)"><i class="fa fa-search"></i></button>
                                    </template>
                                </Column>
                                <Column field="user_ufa" header="User UFA" sortable></Column>
                                <Column field="name" header="Name"></Column>
                                <Column field="tel" header="Tel"></Column>
                                <Column field="code_name" header="Code Name"></Column>
                                <Column field="amt_1" header="First Deposit" sortable></Column>
                                <Column field="cdate" header="Create Date" sortable>
                                    <template #body="{data}">
                                        {{ formatDate(data.cdate) }}
                                    </template>
                                </Column>
                                <template #paginatorstart>
                                    <select class="form-select" v-model="rows.perpage">
                                        <option v-for="value in rows.list" :value="value">{{ value }}</option>
                                    </select>
                                </template>
                                <template #paginatorend>
                                    Total: {{ table.filtered.length }}
                                </template>
                            </Datatable>
                        </template>
                        <template v-else>
                            <div class="card bg-gradient-white d-flex justify-content-center align-items-center" style="height: 12rem">
                                <template v-if="loading">
                                    <span class="text-black-50"><i class="ion-load-c rotation"></i> Loading</span>
                                </template>
                                <template v-else>
                                    <span class="text-black-50">Data not found</span>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="user-modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 class="modal-title">User Info</h4>
                    <hr>
                    <button type="button" class="close" style="position: absolute;right: 12px;top: 8px;font-size: 2rem;font-weight: 400;" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <div class="row row-cols-3">
                        <div class="col d-flex flex-column">
                            <b>AG UFA: </b>
                            <p style="font-size: 14px;">{{ modal.data.ag_ufa || `-` }}</p>
                        </div>
                        <div class="col d-flex flex-column">
                            <b>User UFA: </b>
                            <p style="font-size: 14px;">{{ modal.data.user_ufa || `-` }}</p>
                        </div>
                        <div class="col d-flex flex-column">
                            <b>Registered Date: </b>
                            <p style="font-size: 14px;">{{ formatDate(modal.data.cdate) }}</p>
                        </div>
                        <div class="col d-flex flex-column">
                            <b>Name: </b>
                            <p style="font-size: 14px;">{{ modal.data.name }}</p>
                        </div>
                        <div class="col d-flex flex-column">
                            <b>Tel: </b>
                            <p style="font-size: 14px;">{{ modal.data.tel }}</p>
                        </div>
                        <div class="col d-flex flex-column">
                            <b>Code: </b>
                            <p style="font-size: 14px;">{{ modal.data.code || '-' }}</p>
                        </div>
                    </div>
                    <hr>
                    <p style="font-size: 1.5rem;">Deposit Times</p>
                    <div class="row row-cols-3">
                        <div class="col"><b>First: </b>{{ formatCurrency(modal.data.amt_1) }}</div>
                        <div class="col"><b>Second: </b>{{ formatCurrency(modal.data.amt_2) }}</div>
                        <div class="col"><b>Thrid: </b>{{ formatCurrency(modal.data.amt_3) }}</div>
                        <div class="col">
                            <p><b>Date:</b> {{ formatDate(modal.data.date_1) }}</p>
                        </div>
                        <div class="col">
                            <p><b>Date:</b> {{ formatDate(modal.data.date_2) }}</p>
                        </div>
                        <div class="col">
                            <p><b>Date:</b> {{ formatDate(modal.data.date_3) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const userBox = Vue.createApp({
        data() {
            return {
                loading: false,
                max_month_filter: 4,
                data: {
                    user: 0,
                    rate: 0,
                    deposited: 0,
                    avg: 0,
                    total: 0,
                    channels: []
                },
                modal: {
                    target: null,
                    data: {
                        cdate: ``,
                        name: ``,
                        tel: ``,
                        code: ``,
                        codex: ``,
                        code_name: ``,
                        ag_ufa: ``,
                        user_ufa: ``,
                        amt_1: ``,
                        date_1: ``,
                        amt_2: ``,
                        date_2: ``,
                        amt_3: ``,
                        date_3: ``,
                    },
                },
                filter: ``,
                form: {
                    s_date: dayjs().format('YYYY-MM-DD'),
                    e_date: dayjs().format('YYYY-MM-DD'),
                    code: ``,
                },
                table: {
                    filtered: [],
                    data: [],
                },
                rows: {
                    perpage: 10,
                    list: [10, 25, 50, 100],
                },
            }
        },
        methods: {
            async channels() {
                this.loading = true
                let {
                    status,
                    message,
                    data
                } = await post(`agent/channels`)
                this.loading = false
                if (!status) return flashAlert.warning(message)
                this.data.channels = data
            },
            async list() {
                this.loading = true
                let {
                    status,
                    message,
                    data
                } = await post(`report/registerlistsbycode`, this.form)
                this.loading = false
                if (!status) return flashAlert.warning(message)
                this.table.data = data
                this.filter_user()
                this.calculate_deposit()
            },
            async search_data() {
                if (!this.form) return
                if (this.form.s_date > this.form.e_date)
                    return flashAlert.warning(`วันเริ่มต้นจะต้องน้อยกว่าวันสิ้นสุด`)
                if (dayjs(this.form.e_date).diff(dayjs(this.form.s_date), 'month') > this.max_month_filter)
                    return flashAlert.warning(`ดึงข้อมูลได้ไม่เกิน ${this.max_month_filter} เดือน`)
                await this.list()
            },
            filter_user() {
                let _filter = this.filter
                if (!_filter) return this.table.filtered = this.table.data
                this.table.filtered = this.table.data?.filter((item) => {
                    return item.user_ufa?.indexOf(_filter) > -1 ||
                        item.name?.indexOf(_filter) > -1 ||
                        item.code?.indexOf(_filter) > -1 ||
                        item.tel?.indexOf(_filter) > -1
                }) || []
            },
            // search_code: _.debounce(async function() {
            //     await this.list()
            // }, 500), // Debounce with a 500ms delay
            formatCurrency(value) {
                if (value == '0.00') return '-'
                return value
            },
            formatDate(value) {
                if (value == '0000-00-00') return '-'
                return dayjs(value).format('DD-MM-YYYY')
            },
            view_detail(data) {
                this.modal.data = data
                this.modal.target.modal(`show`)
            },
            calculate_deposit() {
                this.data.user = `0`
                this.data.rate = `0`
                this.data.deposited = `0`
                this.data.avg = `0`
                this.data.total = `0`
                if (!this.table.data.length) return
                const data = this.table.data
                const deposited = data.filter(item => item.amt_1 != '0.00')
                const rate = Math.round((deposited.length * 100) / data.length)
                const total = deposited.reduce((pre, cur) => pre + Number(cur.amt_1), 0)
                this.data.user = format_number_with_commas(data.length)
                this.data.rate = rate
                this.data.deposited = format_number_with_commas(deposited.length)
                this.data.avg = format_number_with_commas((total / data.length).toFixed(2))
                this.data.total = format_number_with_commas(total.toFixed(2))
            }
        },
        async mounted() {
            this.modal.target = $(`#user-modal`)
            await this.channels()
            await this.list()
        }
    })
    userBox.use(PrimeVue.Config, {
        theme: {
            preset: PrimeVue.Themes.Aura
        }
    })
    userBox.component(`Datatable`, PrimeVue.DataTable)
    userBox.component(`Column`, PrimeVue.Column)
    userBox.mount('#user-box')
</script>

<?= $this->endSection() ?>