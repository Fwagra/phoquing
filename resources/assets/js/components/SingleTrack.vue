<template>
    <li class="track"
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
            <div class="category" @click="activated = !activated" v-tooltip.left="trans('tracks.click_comment')">
                {{ track.category }}
            </div>
            <div class="total" :class="{real: track.total && track.end}">
                <span v-if="track.total">
                    {{ track.total }} h
                </span>
                <span v-else>
                    {{ tempTotal }} h
                </span>
            </div>
            <div class="actions" v-show="!this.status">
                <div class="stop" v-tooltip=" trans('tracks.stop') " @click="stop" v-show="!track.end">{{ trans('tracks.stop') }}</div>
                <div class="duplicate" v-tooltip="trans('tracks.continue')" @click="duplicate" v-show="track.end">{{ trans('tracks.continue') }}</div>
                <div class="edit" v-tooltip="trans('tracks.edit')" @click="edit">{{ trans('tracks.edit') }}</div>
                <transition name="rollinleft">
                    <div class="delete" v-tooltip="trans('tracks.delete')" v-show="!deleteConfirm"  @click="deleteConfirm = !deleteConfirm">{{ trans('tracks.delete') }}</div>
                </transition>
                    <div class="delete-actions">
                        <transition name="rollinleft">
                            <div class="delete-confirm" v-tooltip="trans('tracks.delete_confirm')"  v-show="deleteConfirm"  @click="deleteTrack">{{ trans('tracks.delete_confirm') }}</div>
                        </transition>
                        <transition name="rollinright">
                            <div class="delete-cancel" v-tooltip="trans('tracks.delete_cancel')"   v-show="deleteConfirm"  @click="deleteConfirm = !deleteConfirm">{{ trans('tracks.delete_cancel') }}</div>
                        </transition>
                    </div>
            </div>
        </div>
        <div class="lower" >
            <div class="comment" v-show="activated">
                {{ track.comment }}
            </div>
        </div>
    </li>
</template>
<script>
    export default {
        name: 'single-track',
        data() {
            return {
                tempTotal: '0',
                currentTime: '',
                activated: false,
                deleteConfirm: false,
            }
        },
        props: [
            'track',
            'status'
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
                    return (this.track.end )? dateformat(this.track.end, this.$hourFormat) : '';
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
            edit : function () {
                this.$emit('edit', this.track);
            },
            duplicate: function () {
              this.$emit('duplicate', this.track);
            },
            deleteTrack: function () {
                this.$emit('deletetrack', this.track);
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
