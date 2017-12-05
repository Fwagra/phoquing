<template>
    <div class="track" @click="activated = !activated"
         :class="{clickable:track.comment}">
        <div class="upper">
            <div class="hour">
                {{ startTime }} - <span class="end" :class="{real: track.end}">
                    <span v-if="track.end">
                        {{ endTime }}
                    </span>
                    <span v-else>
                        {{ currentTime }}
                    </span>
                </span>
            </div>
            <div class="category">
                {{ track.category }}
            </div>
            <div class="total" :class="{real: track.total}">
                <span v-if="track.total">
                    {{ track.total }}
                </span>
                <span v-else>
                    {{ tempTotal }}
                </span>
            </div>
            <div class="actions">
                <div class="stop" @click="stop" v-show="!track.end">stop</div>
            </div>
        </div>
        <div class="lower" >
            <div class="comment" v-show="activated">
                {{ track.comment }}
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'single-track',
        data() {
            return {
                tempTotal: '0',
                currentTime: '',
                activated: false,
            }
        },
        props: [
            'track'
        ],
        mounted: function () {
            this.liveCalcs();
            let self = this;
            setInterval(function () {
                self.liveCalcs();
            }, 1000 * 60);
        },
        computed: {
            startTime: {
                get: function() {
                    return dateformat(this.track.start, this.$hourFormat);
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
            },
            liveCalcs: function () {
                let tempTotal = 0;
                if (!this.track.end && this.track.start) {
                    let currentTime = Date.now();
                    let startTime = Date.parse(this.track.start);
                    tempTotal = mathPhp.round((currentTime - startTime) / 3600000, 1);
                }
                this.tempTotal = (tempTotal >= 0) ? tempTotal : 0;
                this.currentTime = dateformat(new Date(), this.$hourFormat);
            }
        }
    }
</script>
