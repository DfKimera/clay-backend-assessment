<template>
	<div class="card">
		<loading-feedback :is-loading="isLoading"></loading-feedback>

		<div class="card-header">My locks</div>
		<div class="card-body">

			<div class="row">

				<div class="col-md-6" v-for="lock in locks">
					<div class="card">
						<div class="card-body text-center">
							<h4>{{lock.name}}</h4>
							<div class="py-2">{{lock.location}}</div>
							<div v-if="!lock.is_locked"><strong class="text-success"><i class="fa fa-unlock"></i> Unlocked</strong></div>
							<div v-if="lock.is_locked"><strong class="text-danger"><i class="fa fa-unlock"></i> Locked</strong></div>
						</div>
						<div class="card-footer">
							<div class="btn-group btn-group-justified" role="group">
								<button v-if="!lock.is_locked" @click="lockLock(lock)" type="button" class="btn btn-dark"><i class="fa fa-lock"></i> Lock</button>
								<button v-if="lock.is_locked" @click="unlockLock(lock)" type="button" class="btn btn-dark"><i class="fa fa-unlock"></i> Unlock</button>
								<button @click="viewActivity(lock)" type="button" class="btn btn-outline-dark"><i class="fa fa-history"></i> View activity</button>
							</div>
						</div>
					</div>
				</div>

			</div>

		</div>
		<div class="card-footer">
			<div class="btn-group btn-group-justified" role="group">
				<button type="button" class="btn btn-outline-success" @click="refresh"><i class="fa fa-refresh"></i> Refresh</button>
				<button type="button" class="btn btn-outline-dark" @click="logout"><i class="fa fa-sign-out"></i> Sign out</button>
			</div>
		</div>
	</div>
</template>
<script>
	import Locks from "../services/Locks";

	export default {

		props: ['token'],

		data: () => { return {
			isLoading: false,
			locks: [],
		}},

		mounted() {
			this.refresh();
		},

		methods: {

			async refresh() {
				this.isLoading = true;
				this.locks = await Locks.list(this.token);
				this.isLoading = false;
			},

			logout() {
				this.$emit('logout');
			},

			async lockLock(lock) {
				this.isLoading = true;

				await Locks.lock(lock.id, this.token);
				this.refresh();

				this.isLoading = false;
			},

			async unlockLock(lock) {
				this.isLoading = true;

				await Locks.unlock(lock.id, this.token);
				this.refresh();

				this.isLoading = false;
			},

			viewActivity(lock) {
				this.$emit('view', lock);
			},

		}

	}
</script>