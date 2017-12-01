<current-tracks inline-template>
    <div class="container">
        <div class="content" v-if="countTracks > 0">
            <ul>
                <li
                    v-for="(track, key) in tracks"
                    :key="track.id"
                    @click="track.activated = !track.activated"
                    :class="{clickable:track.comment}"
                >
                    <div class="upper">
                        <div class="hour">
                            @{{ dates[key].start }} - @{{ dates[key].end }}
                        </div>
                        <div class="category">
                            @{{ track.category }}
                        </div>
                        <div class="total">
                            @{{ track.total }}
                        </div>
                    </div>
                    <div class="lower" >
                        <div class="comment"v-show="track.activated">
                            @{{ track.comment }}
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="content" v-else-if="countTracks == 0">
            {{ trans('tracks.no_tracks_found') }}
        </div>
        <div class="content" v-else>
            {{ trans('tracks.loading_tracks') }}
        </div>
        <div class="form">
            <input name="date" type="date" v-model="editedtrack.date">
            <input name="start" type="time" v-model="editedtrack.start">
            <input name="end" type="time" v-model="editedtrack.end">
            <input name="comment" type="text" v-model="editedtrack.comment">
            <input name="category" type="text" v-model="editedtrack.category">
            <input type="button" @click="sendTrack" value="{{ trans('tracks.add_button') }}">
        </div>
    </div>
</current-tracks>