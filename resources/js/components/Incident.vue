<template>
    <div class="box">
        <article class="media">
            <div class="media-content">
                <div class="content">
                    <h1 class="title" style="margin-bottom: 0;">
                        {{ incident.title }}
                    </h1>

                    <p>
                        {{ incident.created_on | moment('dddd, MMMM Do YYYY, hh:mm:ss a') }} ({{ incident.created_on | moment('from', 'now') }}) <small>(ID: {{ incident.id }})</small>
                    </p>

                    <p class="tags" v-if="incident.affected_components">
                        <span
                            v-for="component in incident.affected_components"
                            class="tag"
                        >
                            {{ component }}
                        </span>
                    </p>

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
                                <small>
                                    {{ update.created_on | moment('dddd, MMMM Do YYYY, hh:mm:ss a') }} ({{ update.created_on | moment('from', 'now') }})
                                </small>
                            </p>

                            <p>
                                {{ update.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>
</template>

<script>
    export default {
        props: ['incident'],
        methods: {
            getTagColor: function (type) {
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
            }
        }
    }
</script>
