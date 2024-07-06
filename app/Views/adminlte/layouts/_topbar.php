<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul id="navbar-box" class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <!-- <li class="nav-item d-none d-sm-inline-block">
            <a href="<?= site_url() ?>" class="nav-link">Home</a>
        </li> -->
        <?php if (session()->agent && session()->agent->code) : ?>
            <template v-if="show.registered">
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= site_url(['agent', session()->agent->code, session()->agent->key, session()->agent->secret, 'registered']) ?>" class="nav-link text-primary">Registrations</a>
                </li>
            </template>
            <template v-if="show.cnt">
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= site_url(['agent', session()->agent->code, session()->agent->key, session()->agent->secret, 'cnt']) ?>" class="nav-link text-primary">Deposit Times</a>
                </li>
            </template>
            <template v-if="show.code">
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= site_url(['agent', session()->agent->code, session()->agent->key, session()->agent->secret, 'code']) ?>" class="nav-link text-primary">Search by Code</a>
                </li>
            </template>
        <?php endif ?>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <?php if ($path != '') : ?>
            <li class="nav-item d-none d-sm-inline-block">
                <a class="nav-link fw-bolder text-success"><?= session()->agent && session()->agent->name ? session()->agent->name : "" ?></a>
            </li>
        <?php endif ?>
    </ul>
</nav>
<!-- /.navbar -->

<script>
    Vue.createApp({
        data() {
            return {
                path: `<?= $last_path ?>`,
                show: {
                    registered: false,
                    cnt: false,
                    code: false
                },
            }
        },
        methods: {
            async topMenuManagement() {
                if (this.path == '') return
                this.show.registered = this.path != 'registered';
                this.show.cnt = this.path != 'cnt';
                this.show.code = this.path != 'code';
            },
        },
        mounted() {
            this.topMenuManagement()
        }
    }).mount('#navbar-box')
</script>