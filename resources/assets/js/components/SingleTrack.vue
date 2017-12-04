<template>
    <div class="track" @click="track.activated = !track.activated"
         :class="{clickable:track.comment}">
        <div class="upper">
            <div class="hour">
                {{ startTime }} - {{ endTime }}
            </div>
            <div class="category">
                {{ track.category }}
            </div>
            <div class="total">
                {{ track.total }}
            </div>
            <div class="actions">
                <div class="stop" @click="stop" v-show="!track.end">stop</div>
            </div>
        </div>
        <div class="lower" >
            <div class="comment" v-show="track.activated">
                {{ track.comment }}
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'single-track',
        props: [
            'track'
        ],
        computed: {
            startTime: {
                get: function() {
                    return dateformat(this.track.start, 'HH:MM');
                },
                set: function(value) {
                    this.track.start = dateformat(this.track.date + value);
                }
            },
            endTime: {
                get: function() {
                    return (this.track.end )? dateformat(this.track.end, 'HH:MM') : '';
                },
                set: function(value) {
                    this.track.end = dateformat(this.track.date + value);
                }
            },
        },
        methods: {
            stop : function () {
                this.$emit('stop', this.track);
            }
        }
    }
</script>
