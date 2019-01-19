<template>
    <div class="category-box">
        <div class="category">
            <div class="category-names" style="cursor: pointer;" v-on:click="detailsOpen = !detailsOpen">
                <span
                    class="fas"
                    :class="{[detailsOpen ? 'fa-caret-down' : 'fa-caret-right']: true}"
                    style="color: rgb(127, 127, 127); margin-right: 10px;"
                ></span>

                <strong class="category-name">{{ category.name }}</strong><br/>
                <small v-html="shortDesc"></small>
            </div>

            <div class="category-stats">
                <div class="stat">
                    <span class="name">
                        SERVICES UP
                    </span>

                    <span class="value">
                        {{ monitorsUp }} / {{ monitorAmount }}
                    </span>
                </div>

                <!--
                <div class="stat">
                    <span class="name">
                        SERVICES UP
                    </span>

                    <span class="value">
                        {{ monitorsUp }} / {{ monitorAmount }}
                    </span>
                </div>

                <div class="stat">
                    <span class="name">
                        SERVICES UP
                    </span>

                    <span class="value">
                        {{ monitorsUp }} / {{ monitorAmount }}
                    </span>
                </div>
                -->
            </div>

            <div class="category-graph">
                <!-- the graph goes here -->
            </div>
        </div>

        <div
            class="services"
            :style="{display: detailsOpen ? 'block' : 'none'}"
        >
            <ul>
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
                detailsOpen: window.expandCategoriesByDefault
            }
        },
        computed: {
            monitorAmount() {
                return this.category.monitors.length;
            },
            noProblems() {
                return this.category.monitors.map(this.getMonitorStatus).filter(it => it === MONITOR_STATUS_OPERATIONAL).length === this.monitorAmount;
            },
            monitorsUp() {
                return this.category.monitors.filter(this.isMonitorUp).length;
            },
            monitorsDown() {
                return this.category.monitors.filter(it => !this.isMonitorUp(it)).length;
            },
            monitorsWithIncidents() {
                return this.category.monitors.map(this.getMonitorStatus).filter(it => it === MONITOR_STATUS_HAS_ACTIVE_INCIDENT).length;
            },
            monitorsInMaintenance() {
                return this.category.monitors.map(this.getMonitorStatus).filter(it => it === MONITOR_STATUS_MAINTENANCE).length;
            },
            shortDesc() {
                if (this.noProblems) {
                    if (this.monitorAmount === 0) {
                        return 'No services.';
                    }

                    if (this.monitorAmount === 1) {
                        return 'The service is operational.';
                    }

                    return `All ${this.monitorAmount} services are operational.` ;
                }

                let value = '';

                if (this.monitorsInMaintenance > 0) {
                    value += `${this.monitorsInMaintenance} service${this.monitorsInMaintenance > 1 ? 's are' : ' is'} in maintenance. `;
                }

                if (this.monitorsWithIncidents > 0) {
                    value += `${this.monitorsWithIncidents} service${this.monitorsWithIncidents > 1 ? 's have' : ' has'} an incident. `;
                }

                if (value.length > 0) {
                    return value;
                }

                return `${this.monitorsDown} service${this.monitorsDown > 1 ? 's are' : ' is'} down.`;
            }
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
    };
</script>
