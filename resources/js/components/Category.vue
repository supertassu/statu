<template>
    <div>
        <div class="panel-block" v-on:click="detailsOpen = !detailsOpen" style="cursor: pointer;">
            <span class="icon category-toggler">
                <span class="fas" :class="{[detailsOpen ? 'fa-minus-square' : 'fa-plus-square']: true}"></span>
            </span>

            <span class="icon" :class="{[color]: true}">
                <span class="fas fa-check" v-if="isOperational">&nbsp;</span>
                <span class="fas fa-exclamation-triangle" v-else-if="percentageDown < 50"></span>
                <span class="fas fa-times" v-else></span>
            </span>

            <strong>{{ category.name }}</strong>

            <span :class="{[color]: true}" style="position: absolute; right: 10px;">
                <span v-if="isOperational">
                    Operational
                </span>

                <span v-else>
                    <strong :class="{[color]: true}">{{ monitorsDown }}</strong>
                    service{{ monitorsDown === 1 ? '' : 's' }} down
                    (out of&nbsp;{{ totalMonitors }}, {{ percentageDown }}% down)
                </span>
            </span>
        </div>

        <div
            class="panel-block"
            :id="'details-category-' + category.id"
            style="border-bottom: none;"
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
        data: function() {
            return {
                detailsOpen: false
            };
        },
        computed: {
            totalMonitors: function() {
                return this.category.monitors.length;
            },
            monitorsDown: function() {
                return this.category.monitors.filter(it => it.activeIncidents.length > 0).length;
            },
            isOperational: function() {
                return this.monitorsDown === 0;
            },
            percentageDown: function() {
                return (this.monitorsDown / this.totalMonitors) * 100;
            },
            color: function() {
                const percentage = this.percentageDown;

                if (percentage === 0) {
                    return 'has-text-success';
                }

                if (percentage < 50) {
                    return 'has-text-orange';
                }

                return 'has-text-danger';
            }
        },
        methods: {
            getMonitorColor: function(monitor) {
                if (monitor.activeIncidents.length > 0) {
                    return 'warning';
                }

                return 'success';
            },
            getMonitorText: function(monitor) {
                if (monitor.activeIncidents.length > 0) {
                    return 'OUTAGE';
                }

                return 'OPERATIONAL';
            }
        }
    }
</script>
