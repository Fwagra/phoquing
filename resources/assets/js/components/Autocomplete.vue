<script>
    export default {
        data() {
            return {
                open: false,
                current: 0,
                suggestions : [],
                selected: ''
            }
        },
        computed: {
            openSuggestion() {
                return this.selection !== "" && this.open === true;
            }
        },
        props: [
            'selection'
        ],
        created() {
            this.selected = this.selection
        },
        methods: {
            enter(q) {
                if  (!_.isEmpty(this.suggestions)) {
                    this.selected = this.suggestions[this.current];
                } else {
                    this.selected = q;
                }

                this.open = false;
                this.$emit('input', this.selected);

            },
            up() {
                if(this.current > 0)
                    this.current--;
            },
            down() {
                if(this.current < this.suggestions.length - 1)
                    this.current++;
            },
            isActive(index) {
                return index === this.current;
            },
            change(q) {
                if  (q.length == 0)
                    this.suggestions = [];

                this.selected = q;

                if (q.length > 1)
                    this.makeQuery(q);


                this.$emit('input', this.selected);
            },
            suggestionClick(index) {
                this.selected = this.suggestions[index];

                this.open = false;
                this.$emit('input', this.selected);

            },
            makeQuery: function (q) {
                this.$resource('track-categories/' + q).get().then((response) => {
                    this.suggestions = response.body;

                    if(_.isEmpty(response.body))
                        this.open = false;

                    if (this.open == false && !_.isEmpty(response.body)) {
                        this.open = true;
                        this.current = 0;
                    }
                })
            }
        }
    }
</script>
<template>
    <div style="position:relative" v-bind:class="{'open':openSuggestion}">
        <input  type="text"
               @keydown.enter = 'enter($event.target.value)'
               @keydown.tab = 'enter($event.target.value)'
               @keydown.down = 'down'
               @keydown.up = 'up'
               :value="selection"
               @input = 'change($event.target.value)'
        />
        <ul class="dropdown-menu" style="width:100%">
            <li v-for="(suggestion, index) in suggestions"
                v-bind:class="{'active': isActive(index)}"
                @click="suggestionClick(index)"
            >
                <a href="#">{{ suggestion }}</a>
            </li>
        </ul>
    </div>
</template>