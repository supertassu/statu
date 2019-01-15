<template>
    <div class="box">
        <article class="media">
            <div class="media-content">
                <div class="content">
                    <h1 class="title">
                        {{ incident.title }}
                    </h1>

                    <div class="tags" style="margin-bottom: 0;">
                        <span class="tag is-danger">Created at</span>
                        <span class="tag">
                            {{ incident.created_on | moment() }}
                            ({{ incident.created_on | moment('from', 'now') }})
                        </span>
                    </div>

                    <div class="tags" v-if="incident.affected_components">
                        <span class="tag is-danger">Affected components</span>

                        <span
                            v-for="component in incident.affected_components"
                            class="tag"
                        >
                            {{ getMonitorName(component) }}
                        </span>
                    </div>

                    <p>
                        {{ incident.description }}
                    </p>

                    <div
                        v-if="incident.updates"
                        v-for="update in incident.updates"
                        :key="update.id">
                        <div class="notification">
                            <p>
                                <span v-bind:class="{ tag: true, ['is-' + getTagColor(update.type)]: true }">
                                    {{ update.type }}
                                </span>

                                <strong>{{ update.title }}</strong>
                            </p>

                            <p>
                                {{ update.description }}

                                <br/>
                                <small>
                                    {{ update.created_on | moment() }} ({{ update.created_on | moment('from', 'now') }})
                                </small>
                            </p>
                        </div>
                    </div>
                </div>

                <small>
                    Incident ID #{{ incident.id }}
                </small>
            </div>
        </article>
    </div>
</template>

<script>
    export default {
        props: ['incident', 'monitors'],
        methods: {
            getTagColor(type) {
                switch (type) {
                    case 'update':
                        return 'info';
                    case 'monitoring':
                        return 'link';
                    case 'investigating':
                        return 'primary';
                    case 're-opened':
                        return 'danger';
                    case 'solved':
                        return 'success';
                    default:
                        return 'light';
                }
            },
            getMonitorName(id) {
                const monitor = this.monitors.filter(it => it.id === id);

                if (monitor.length !== 1) {
                    return '<unknown component>';
                }

                return monitor[0].name;
            }
        }
    }
</script>
