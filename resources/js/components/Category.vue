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
                return this.monitorsDown === 0 && this.monitorsInMaintenance === 0;
            },
            monitorsDown() {
                return this.category.monitors.filter(it => it.activeIncidents.length > 0).length;
            },
            monitorsInMaintenance() {
                return this.category.monitors.filter(it => it.activeMaintenance.length > 0).length;
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

                if (this.percentageDown === 100) {
                    value += '<span class="tag is-danger">DOWN</span>';
                } else if (this.percentageDown > 0) {
                    value += '<span class="tag is-danger">' +
                        `OUTAGE: ${this.monitorsDown} service${this.monitorsDown === 1 ? '' : 's'} out of ` +
                        `${this.totalMonitors} ${this.monitorsDown === 1 ? 'is' : 'are'} down</span> `;
                }

                return value;
            },
            color() {
                if (this.isOperational) {
                    return 'success';
                }

                if (this.percentageDown === 0) {
                    // maintenance only
                    return 'primary';
                }

                if (this.percentageDown === 100) {
                    return 'danger';
                }

                return 'orange';
            },
            tagText() {
                if (this.isOperational) {
                    return 'OPERATIONAL';
                }

                if (this.percentageDown === 0) {
                    // maintenance only
                    return 'MAINTENANCE';
                }

                if (this.percentageDown === 100) {
                    return 'DOWN';
                }

                return `OUTAGE: ${this.monitorsDown} service${this.monitorsDown === 1 ? '' : 's'} out of ${this.totalMonitors} ${this.monitorsDown === 1 ? 'is' : 'are'} down`;
            }
        },
        methods: {
            getMonitorColor(monitor) {
                if (monitor.activeIncidents.length > 0) {
                    return 'danger';
                }

                if (monitor.activeMaintenance.length > 0) {
                    return 'primary';
                }

                return 'success';
            },
            getMonitorText(monitor) {
                if (monitor.activeIncidents.length > 0) {
                    return 'DOWN';
                }

                if (monitor.activeMaintenance.length > 0) {
                    return 'MAINTENANCE';
                }

                return 'OPERATIONAL';
            }
        }
    }
</script>
