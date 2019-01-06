<template>
    <section v-if="failed">
        <failed-to-load title="We're sorry, we're not able to retrieve this information at the moment, please try back later."></failed-to-load>
    </section>

    <section v-else>
        <div v-if="lastLoaded" class="has-text-right">
            <small>Data was last updated at {{ lastLoaded.format('HH:mm:ss') }}. Data will be updated automatically every 30 seconds.</small>
        </div>

        <loading v-if="loading"></loading>

        <incident
            v-else
            v-for="incident in activeIncidents"
            v-bind:incident="incident"
            :key="incident.id"
        ></incident>

        <div v-if="allFine" class="notification is-success">
            <span class="icon">
                <i class="fas fa-check-square"></i>
            </span>

            All systems operational.
        </div>

    </section>
</template>

<script>
    export default {
        data() {
            return {
                lastLoaded: null,
                incidents: null,
                loading: true,
                failed: false
            };
        },

        computed: {
            activeIncidents() {
                if (!this.incidents) {
                    return [];
                }

                return this.incidents.filter(function(incident) {
                    return incident.resolved === null;
                });
            },

            allFine() {
                if (!this.incidents) {
                    return false;
                }

                const noIncidents = this.incidents.filter(function(incident) {
                    return incident.resolved === null;
                }).length === 0;

                return noIncidents;
            }
        },

        methods: {
            loadData: function() {
                axios
                    .get('/api/incidents')
                    .then(response => {
                        this.incidents = response.data;
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
