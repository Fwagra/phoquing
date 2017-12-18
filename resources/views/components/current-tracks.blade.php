<current-tracks inline-template>
    <div class="container">
        <div class="panel track-form" :class="{ edition : status }">
            <div class="panel-heading">
                <span v-if="status == 'edition'">
                    {{ trans('tracks.edit_task') }}
                </span>
                <span v-else>
                    {{ trans('tracks.add_new') }}
                </span>
            </div>
            <div class="panel-content">
                <div class="form-container">
                    <div class="form">
                        <div class="form-control">
                            <label for="date" class="col-md-4 control-label">{{ trans('tracks.date') }}</label>
                            <div class="input-wrapper">
                                <input name="date" type="date" v-model="editedtrack.date">
                            </div>
                        </div>
                        <div  class="form-control">
                            <label for="start" class="col-md-4 control-label">{{ trans('tracks.start') }}</label>
                            <div class="input-wrapper">
                                <input name="start" type="time" v-model="editedStart">
                            </div>
                        </div>
                        <div class="form-control">
                            <label for="end" class="col-md-4 control-label">{{ trans('tracks.end') }}</label>
                            <div class="input-wrapper">
                                 <input name="end" type="time" v-model="editedEnd">
                            </div>
                        </div>
                        <div class="form-control">
                            <label for="comment" class="col-md-4 control-label">{{ trans('tracks.comment') }}</label>
                            <div class="input-wrapper">
                                <input name="comment" type="text" v-model="editedtrack.comment">
                            </div>
                        </div>
                        <div class="form-control">
                            <label for="category" class="col-md-4 control-label">{{ trans('tracks.category') }}</label>
                            <div class="input-wrapper">
                                <autocomplete :selection="editedtrack.category" v-model="editedtrack.category"></autocomplete>
                            </div>
                        </div>
                        <div class="actions-panel">
                            <input type="button" class="btn" @click="sendInputTrack" value="{{ trans('tracks.add_button') }}">
                            <input class="btn btn-error"  v-show="status == 'edition'" type="button" @click="cancelEditTrack" value="{{ trans('tracks.cancel_edit_button') }}">
                        </div>
                    </div>
                    <div class="errors" v-show="errors">
                        <div class="error" v-for="(error, key, index) in errors">
                            @{{ error[0] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row fifty">
            <div class="panel time-container">
                <div class="panel-heading">
                    {{ trans('tracks.tracks_title') }}
                    <span class="filters">
                        <transition name="rollinright">
                            <span class="reset-filters"  @click="this.resetFilters" v-show="this.displayReset"></span>
                        </transition>
                        <input type="date" name="date" class="date" v-model="date">
                        <input type="date" name="dateEnd" class="date date-end" v-model="dateEnd">
                    </span>
                </div>
                <div class="panel-body content" v-if="countTracks > 0">
                    <ul v-if="this.filtered">
                        <div v-for="(groupTracks, key) in this.grouped">
                            <div class="day">
                               <span>
                                   @{{ key }}
                               </span>
                            </div>
                            <li
                                    is="single-track"
                                    v-for="(track, key) in groupTracks"
                                    :key="track.id"
                                    :track="track"
                                    :status="status"
                                    @@stop="stopTrack"
                                    @edit="editTrack"
                                    @duplicate="duplicateTrack"
                                    @deletetrack="deleteTrack"
                            >
                            </li>
                        </div>

                    </ul>
                    <ul v-else>
                        <li
                            is="single-track"
                            v-for="(track, key) in tracks"
                            :key="track.id"
                            :track="track"
                            :status="status"
                            @@stop="stopTrack"
                            @duplicate="duplicateTrack"
                            @edit="editTrack"
                            @deletetrack="deleteTrack"
                        >
                        </li>
                    </ul>
                </div>
                <div class="panel-body content" v-else-if="countTracks == 0 && this.displayReset">
                    {{ trans('tracks.no_tracks_found_yet') }}
                </div>
                <div class="panel-body content" v-else-if="countTracks == 0">
                    {{ trans('tracks.no_tracks_found') }}
                </div>
                <div class="panel-body content" v-else>
                    {{ trans('tracks.loading_tracks') }}
                </div>
            </div>
            <div class="panel stats-container">
                <div class="panel-heading">
                    {{ trans('tracks.stats_title') }}
                </div>
                <div class="panel-body">
                    <stats :tracks="tracks" v-on:openmodal="populateModal"></stats>
                </div>
            </div>
        </div>
        <modal v-if="showModal" @close="showModal = false">
            <p slot="body" v-html="modalText">
            </p>
        </modal>

    </div>
</current-tracks>