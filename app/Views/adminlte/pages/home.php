<?= $this->extend("adminlte/layouts/basic") ?>

<?= $this->section("content") ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="text-center">Agents</h1>
            </div>
        </div>
    </div>
</section>

<section class="content" id="agent-box">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex flex-row justify-content-between">
                            <input type="search" class="form-control w-50" placeholder="Search..." v-model="filter" @input="filter_agent">
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="agent-table" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Code</th>
                                    <th>Key</th>
                                    <th>Secret</th>
                                    <th>Web</th>
                                    <th class="text-center">Report</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(data, index) in table.filtered">
                                    <td>{{ data.name }}</td>
                                    <td>{{ data.code }}</td>
                                    <td>{{ data.key }}</td>
                                    <td>{{ data.secret }}</td>
                                    <td>{{ data.web }}</td>
                                    <td>
                                        <div class="d-flex flex-row justify-content-center">
                                            <button type="button" class="btn btn-xs btn-primary me-2" @click="view_report(data, 'registered')">Registrations</button>
                                            <button type="button" class="btn btn-xs btn-warning me-2" @click="view_report(data, 'cnt')">Deposit Times</button>
                                            <button type="button" class="btn btn-xs btn-success" @click="view_report(data, 'code')">Search by Code</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    Vue.createApp({
        data() {
            return {
                loading: false,
                filter: ``,
                modal: {
                    target: null,
                    form: null,
                    darft: {
                        id: ``,
                        key: ``,
                        secret: ``,
                        web: ``,
                        name: ``,
                    }
                },
                table: {
                    filtered: [],
                    data: [],
                },
            }
        },
        methods: {
            async list() {
                this.loading = true
                let {
                    status,
                    message,
                    data
                } = await post(`agent/list`)
                this.loading = false
                if (!status) return flashAlert.warning(message)
                this.table.data = data
                this.filter_agent()
            },
            filter_agent() {
                let _filter = this.filter.toLowerCase()
                if (!_filter) return this.table.filtered = this.table.data
                this.table.filtered = this.table.data?.filter((item) => {
                    return item.username?.toLowerCase().indexOf(_filter) > -1 || item.name?.toLowerCase().indexOf(_filter) > -1 || item.tel?.indexOf(_filter) > -1
                }) || []
            },
            view_report(agent, type) {
                if (!agent) return
                location.href = `<?= site_url('agent') ?>/${agent.code}/${agent.key}/${agent.secret}/${type}`
            },
        },
        async mounted() {
            this.modal.target = $(`#agent-modal`)
            await this.list()
        }
    }).mount('#agent-box')
</script>

<?= $this->endSection() ?>