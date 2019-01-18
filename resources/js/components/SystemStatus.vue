<template>
    <section v-if="failed">
        <failed-to-load title="We're sorry, we're not able to retrieve this information at the moment, please try back later."></failed-to-load>
    </section>

    <section v-else>
        <div v-if="lastLoaded" class="has-text-right">
            <small>Data was last updated at {{ lastLoaded.format('HH:mm:ss') }}. Data will be updated automatically every {{ refreshTime }} seconds.</small>
        </div>

        <loading v-if="loading"></loading>

        <div v-else>
            <div v-if="allFine" class="notification is-success">
                <span class="icon">
                    <i class="fas fa-check"></i>
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
                style="margin-top: 10px;"
            ></div>

            <h1
                class="title"
                v-if="activeMaintenance.length > 0">
                Ongoing maintenance
            </h1>

            <maintenance
                v-for="maintenance in activeMaintenance"
                :maintenance="maintenance"
                :key="'maintenance-' + maintenance.id"
                :monitors="data.monitors"
            ></maintenance>

            <div
                v-if="activeMaintenance.length !== 0"
                style="margin-top: 10px;"
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
                refreshTime: window.refreshTime,
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

                return this.data.incidents.filter(incident => !incident.resolved);
            },

            activeMaintenance() {
                if (!this.data || !this.data.maintenances) {
                    return [];
                }

                return this.data.maintenances.filter(maintenance => !maintenance.closed && moment(maintenance.start).isBefore(moment()));
            },

            categories() {
                if (!this.data || !this.data.incidents || !this.data.categories) {
                    return [];
                }

                return this.data.categories.map(cat => {
                    return Object.assign({}, cat, {
                        monitors: cat.monitors.map(it => {
                            return Object.assign({}, it, {
                                activeIncidents: this.activeIncidents.filter(incident => (incident.affected_components || []).includes(it.id)),
                                activeMaintenance: this.activeMaintenance.filter(maintenance => (maintenance.affected_components || []).includes(it.id))
                            });
                        })
                    });
                });
            },

            allFine() {
                if (!this.data || !this.data.monitors) return;

                const noIncidents = this.activeIncidents.length === 0;
                const noMaintenance = this.activeMaintenance.length === 0;
                const noneDown = this.data.monitors.filter(it => !it.last_status).length === 0;

                return noIncidents && noMaintenance && noneDown;
            }
        },

        methods: {
            loadData: function() {
                axios
                    .get(apiBaseUrl + 'api/overview')
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
            setInterval(() => this.loadData(), refreshTime * 1000);

            this.loadData();
        }
    }
</script>
