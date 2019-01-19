<template>
    <div style="margin-bottom: 1em;">
        <div class="menu-label flex is-marginless" style="cursor: pointer;" v-on:click="detailsOpen = !detailsOpen">
            <span>
                <span
                    class="fas"
                    :class="{[detailsOpen ? 'fa-caret-down' : 'fa-caret-right']: true}"
                    style="color: rgb(127, 127, 127); margin-right: 10px;"
                ></span>

                <strong>{{ category.name }}</strong>
            </span>

            <span v-html="tag"></span>
        </div>

        <div
            class="menu-list"
            :style="{display: detailsOpen ? 'block' : 'none'}"
        >
            <ul
            >
                <li
                    class="flex"
                    v-for="monitor in category.monitors"
                >
                    <strong>{{ monitor.name }}</strong>

                    <span
                        v-bind:class="{ ['has-text-' + getMonitorColor(monitor)]: true }"
                        v-html="getMonitorText(monitor)"></span>
                </li>
            </ul>
        </div>
    </div>

</template>

<script>
    const MONITOR_STATUS_OPERATIONAL = 'operational';
    const MONITOR_STATUS_MAINTENANCE = 'maintenance';
    const MONITOR_STATUS_IS_DOWN = 'down';
    const MONITOR_STATUS_HAS_ACTIVE_INCIDENT = 'incident';

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
                return this.category.monitors.map(this.getMonitorStatus).filter(it => it === MONITOR_STATUS_HAS_ACTIVE_INCIDENT || it === MONITOR_STATUS_IS_DOWN).length;
            },
            monitorsWithIncidents() {
                return this.category.monitors.map(this.getMonitorStatus).filter(it => it === MONITOR_STATUS_HAS_ACTIVE_INCIDENT).length;
            },
            monitorsInMaintenance() {
                return this.category.monitors.map(this.getMonitorStatus).filter(it => it === MONITOR_STATUS_MAINTENANCE).length;
            },
            monitorsDown() {
                return this.category.monitors.map(this.getMonitorStatus).filter(it => it === MONITOR_STATUS_IS_DOWN).length;
            },
            badPercentage() {
                return (this.badMonitors / this.totalMonitors) * 100;
            },
            percentageWithIncidents() {
                return (this.monitorsWithIncidents / this.totalMonitors) * 100;
            },
            tag() {
                if (this.isOperational) {
                    return '<span class="tag is-success">Operational</span>';
                }

                let value = '';

                if (this.monitorsInMaintenance > 0) {
                    value += '<span class="tag is-info">Maintenance</span> ';
                }

                if (this.badPercentage === 100) {
                    value += '<span class="tag is-danger">Down</span>';
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
            getMonitorStatus(monitor) {
                if (monitor.activeIncidents.length > 0) {
                    return MONITOR_STATUS_HAS_ACTIVE_INCIDENT;
                }

                if (monitor.activeMaintenance.length > 0) {
                    return MONITOR_STATUS_MAINTENANCE;
                }

                if (!monitor.last_status) {
                    return MONITOR_STATUS_IS_DOWN;
                }

                return MONITOR_STATUS_OPERATIONAL;
            },
            isMonitorUp(monitor) {
                return monitor.last_status;
            },
            getMonitorColor(monitor) {
                switch (this.getMonitorStatus(monitor)) {
                    case MONITOR_STATUS_HAS_ACTIVE_INCIDENT:
                        return 'orange';
                    case MONITOR_STATUS_MAINTENANCE:
                        return 'info';
                    case MONITOR_STATUS_IS_DOWN:
                        return 'danger';
                    case MONITOR_STATUS_OPERATIONAL:
                    default:
                        return 'success';
                }
            },
            getMonitorText(monitor) {
                switch (this.getMonitorStatus(monitor)) {
                    case MONITOR_STATUS_HAS_ACTIVE_INCIDENT:
                        return (this.isMonitorUp(monitor) ? 'Up' : 'Down') + ' <small>(incident)</small>';
                    case MONITOR_STATUS_MAINTENANCE:
                        return (this.isMonitorUp(monitor) ? 'Up' : 'Down') + ' <small>(maintenance)</small>';
                    case MONITOR_STATUS_IS_DOWN:
                        return 'Outage';
                    case MONITOR_STATUS_OPERATIONAL:
                    default:
                        return 'Operational';
                }
            }
        }
    }
</script>
