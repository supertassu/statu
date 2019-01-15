<template>
    <div>
        <div class="panel-block" v-on:click="detailsOpen = !detailsOpen" style="cursor: pointer;">
            <span class="icon category-toggler">
                <span
                    class="fas"
                    :class="{[detailsOpen ? 'fa-minus-square' : 'fa-plus-square']: true}"
                    style="color: rgb(127, 127, 127); margin-right: 10px;"
                ></span>
            </span>

            <strong>{{ category.name }}</strong>

            <span style="position: absolute; right: 10px;" v-html="tag">

            </span>
        </div>

        <div
            class="panel-block"
            :id="'details-category-' + category.id"
            style="border-top: none;"
            :style="{display: detailsOpen ? 'block' : 'none'}"
        >
            <div
                v-for="monitor in category.monitors"
            >
                <p>
                    <span v-bind:class="{ tag: true, ['is-' + getMonitorColor(monitor)]: true }">
                        {{ getMonitorText(monitor) }}
                    </span>

                    <strong>{{ monitor.name }}</strong>
                </p>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['category'],
        data() {
            return {
                detailsOpen: false
            };
        },
        computed: {
            totalMonitors() {
                return this.category.monitors.length;
            },
            isOperational() {
                return this.badMonitors === 0 && this.monitorsInMaintenance === 0;
            },
            badMonitors() {
                return this.category.monitors.filter(it => it.activeIncidents.length > 0 || !it.last_status).length;
            },
            monitorsWithIncidents() {
                return this.category.monitors.filter(it => it.activeIncidents.length > 0).length;
            },
            monitorsDown() {
                return this.category.monitors.filter(it => !it.last_status).length;
            },
            monitorsInMaintenance() {
                return this.category.monitors.filter(it => it.activeMaintenance.length > 0).length;
            },
            badPercentage() {
                return (this.badMonitors / this.totalMonitors) * 100;
            },
            percentageWithIncidents() {
                return (this.monitorsWithIncidents / this.totalMonitors) * 100;
            },
            percentageDown() {
                return (this.monitorsDown / this.totalMonitors) * 100;
            },
            percentageInMaintenance() {
                return (this.monitorsInMaintenance / this.totalMonitors) * 100;
            },
            tag() {
                if (this.isOperational) {
                    return '<span class="tag is-success">OPERATIONAL</span>';
                }

                let value = '';

                if (this.percentageInMaintenance > 0) {
                    value += '<span class="tag is-primary">MAINTENANCE</span> ';
                }

                if (this.badPercentage === 100) {
                    value += '<span class="tag is-danger">DOWN</span>';
                } else {
                    if (this.monitorsDown > 0) {
                        value += '<span class="tag is-orange">' +
                            `${this.monitorsDown} service${this.monitorsDown === 1 ? '' : 's'} out of ` +
                            `${this.totalMonitors} ${this.monitorsDown === 1 ? 'is' : 'are'} down</span> `;
                    }

                    if (this.monitorsWithIncidents > 0) {
                        value += '<span class="tag is-orange">' +
                            `${this.monitorsWithIncidents} service${this.monitorsWithIncidents === 1 ? '' : 's'} out of ` +
                            `${this.totalMonitors} ${this.monitorsWithIncidents === 1 ? 'has' : 'have'} an active incident</span> `;
                    }
                }

                return value;
            },
        },
        methods: {
            getMonitorColor(monitor) {
                if (monitor.activeIncidents.length > 0) {
                    return 'danger';
                } else if (!monitor.last_status) {
                    return 'orange';
                }

                if (monitor.activeMaintenance.length > 0) {
                    return 'primary';
                }

                return 'success';
            },
            getMonitorText(monitor) {
                if (monitor.activeMaintenance.length > 0) {
                    return 'MAINTENANCE';
                } else if (!monitor.last_status) {
                    return 'DOWN';
                }

                if (monitor.activeIncidents.length > 0) {
                    return 'ACTIVE INCIDENT';
                }

                return 'OPERATIONAL';
            }
        }
    }
</script>
