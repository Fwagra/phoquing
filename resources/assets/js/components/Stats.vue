<template>
    <div class="stats">
        <ul v-if="tracks">
            <li v-for="stat in orderedStats" @click="openModal(stat)">
                <div class="bar" :style="{width: stat.percentage}"></div>
                <div class="name">
                    {{ stat.category }}
                </div>
                <div class="time">
                    {{ stat.total }} h
                </div>
            </li>
        </ul>
        <div class="bottom">
            <div class="total">
                {{ totalTime }} h
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'stats',
        data() {
            return {
                totalTime: 0,
                highestTotal:0,
                stats: {},
            }
        },
        props: [
            'tracks',
        ],
        mounted: function () {
            this.generateStats()
        },
        watch: {
            tracks: {
                handler: function (after, before) {
                    this.generateStats()
                },
                deep: true
            }
        },
        computed: {
          orderedStats : function () {
              return _.orderBy(this.stats,'total', 'desc');
          }
        },
        methods: {
            generateStats: function() {
                this.stats = [];
                this.totalTime = 0;
                this.tracks.forEach(function (track) {

                    if (!track.end)
                        return;

                    // Generate the array of stats
                    let current = this.stats.find(stat => stat.category === track.category);
                    if (current) {
                        current.total = mathPhp.round(current.total + track.total,1)
                    }else {
                        let temp = {
                            category: track.category,
                            total: mathPhp.round(track.total,1),
                            percentage: 100
                        };
                        this.stats.push(temp);
                    }

                    // Increment the total time
                    this.totalTime += track.total;

                }, this);
                this.totalTime = mathPhp.round(this.totalTime, 1);
//                this.updateHighest();
                this.generatePercentages();
            },
            updateHighest: function () {
                this.stats.forEach(function (stat) {
                    this.highestTotal = (stat.total > this.highestTotal) ? stat.total : this.highestTotal;
                }, this)
            },
            generatePercentages: function() {
                this.stats.forEach(function (stat) {
                    stat.percentage = mathPhp.round((stat.total * 100 ) /  this.totalTime,1) + "%";
                }, this)
            },
            openModal: function (stat) {
                this.$emit('openmodal', stat.category);
            }
        }
    }
</script>
