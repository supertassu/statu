<template>
    <section v-if="failed">
        <failed-to-load title="We're sorry, we're not able to retrieve this information at the moment, please try back later."></failed-to-load>
    </section>

    <section v-else>
        <div v-if="lastLoaded" class="has-text-right">
            <small>Data was last updated at {{ lastLoaded.format('HH:mm:ss') }}. Data will be updated automatically every 30 seconds.</small>
        </div>

        <loading v-if="loading"></loading>

        <div v-else>
            <div v-if="allFine" class="notification is-success">
                <span class="icon">
                    <i class="fas fa-check-square"></i>
                </span>

                All systems operational.
            </div>

            <h1
                class="title"
                v-if="activeIncidents.length > 0">
                Incidents
            </h1>

            <incident
                v-for="incident in activeIncidents"
                :incident="incident"
                :key="'incident-' + incident.id"
                :monitors="data.monitors"
            ></incident>

            <div
                v-if="activeIncidents.length !== 0"
                style="marginTop: 10px;"
            ></div>

            <h1 class="title">
                All services
            </h1>

            <div class="panel">
                <category
                    v-for="category in categories"
                    :category="category"
                    :key="'category-' + category.id"
                ></category>
            </div>
        </div>

    </section>
</template>

<script>
    export default {
        data() {
            return {
                lastLoaded: null,
                data: null,
                components: null,
                loading: true,
                failed: false
            };
        },

        computed: {
            activeIncidents() {
                if (!this.data || !this.data.incidents) {
                    return [];
                }

                return this.data.incidents.filter(incident => incident.resolved === '0');
            },

            categories() {
                if (!this.data || !this.data.incidents || !this.data.categories) {
                    return [];
                }

                return this.data.categories.map(cat => {
                    return Object.assign({}, cat, {
                        monitors: cat.monitors.map(it => {
                            return Object.assign({}, it, {
                                activeIncidents: this.data.incidents.filter(incident => {
                                    return (incident.affected_components || []).includes(it.id) && incident.resolved === '0';
                                })
                            });
                        })
                    });
                });
            },

            allFine() {
                if (this.loading || !this.data || !this.data.incidents) {
                    return false;
                }

                const noIncidents = this.data.incidents.filter(incident => incident.resolved === '0').length === 0;

                return noIncidents;
            }
        },

        methods: {
            loadData: function() {
                axios
                    .get('/api/overview')
                    .then(response => {
                        this.data = response.data;
                        this.lastLoaded = moment();
                    })
                    .catch(error => {
                        console.log(error);
                        this.failed = true;
                    })
                    .finally(() => this.loading = false);
            }
        },

        mounted() {
            setInterval(function () {
                this.loadData();
            }.bind(this), 30000);

            this.loadData();
        }
    }
</script>
