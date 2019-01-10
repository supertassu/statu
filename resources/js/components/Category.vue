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

            <span :class="{['has-text-' + color]: true}" style="position: absolute; right: 10px;">
                <span class="tag is-success" v-if="isOperational">
                    Operational
                </span>

                <span
                    v-else
                    :class="{tag: true, ['is-' + color]: true}"
                >
                    {{ tagText }}
                </span>
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
                    return 'success';
                }

                if (percentage === 100) {
                    return 'danger';
                }

                return 'orange';
            },
            tagText() {
                const percentage = this.percentageDown;

                if (percentage === 100) {
                    return 'DOWN';
                }

                if (percentage === 0) {
                    return 'OPERATIONAL';
                }

                return `OUTAGE: ${this.monitorsDown} service${this.monitorsDown === 1 ? '' : 's'} out of ${this.totalMonitors} ${this.monitorsDown === 1 ? 'is' : 'are'} down`;
            }
        },
        methods: {
            getMonitorColor: function(monitor) {
                if (monitor.activeIncidents.length > 0) {
                    return 'danger';
                }

                return 'success';
            },
            getMonitorText: function(monitor) {
                if (monitor.activeIncidents.length > 0) {
                    return 'DOWN';
                }

                return 'UP';
            }
        }
    }
</script>
