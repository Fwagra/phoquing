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
            <div class="total" :class="{real: track.total}">
                <span v-show="track.total">
                    {{ track.total }}
                </span>
                <span v-show="tempTotal">
                    {{ tempTotal }}
                </span>
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
        data() {
            return {
                tempTotal: '0'
            }
        },
        props: [
            'track'
        ],
        mounted: function () {
            this.calculateTempTotal();
            let self = this;
            setInterval(function () {
                self.calculateTempTotal();
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
            calculateTempTotal: function () {
                let tempTotal = 0;
                if (!this.track.end && this.track.start) {
                    let currentTime = Date.now();
                    let startTime = Date.parse(this.track.start);
                    tempTotal = mathPhp.round((currentTime - startTime) / 3600000, 1);
                }
                this.tempTotal = tempTotal;
            }
        }
    }
</script>
