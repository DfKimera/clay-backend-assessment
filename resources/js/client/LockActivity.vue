<template>
	<div class="card">
		<loading-feedback :is-loading="isLoading"></loading-feedback>

		<div class="card-header"><i class="fa fa-lock"></i> Lock: <strong>{{lock.name}}</strong></div>
		<div class="card-body">

			<table class="table">
				<tbody>
					<tr v-for="access in activity">
						<td>{{access.created_at}}</td>
						<td>{{access.accessor.name}}</td>
						<td>
							<strong v-if="access.access_type === 'lock'" class="text-danger"><i class="fa fa-lock"></i> locked</strong>
							<strong v-if="access.access_type === 'unlock'" class="text-success"><i class="fa fa-unlock"></i> unlocked</strong>
						</td>
					</tr>
				</tbody>
			</table>

		</div>
		<div class="card-footer">
			<div class="btn-group btn-group-justified" role="group">
				<button type="button" class="btn btn-outline-success" @click="refresh"><i class="fa fa-refresh"></i> Refresh</button>
				<button type="button" class="btn btn-outline-dark" @click="back"><i class="fa fa-arrow-left"></i> Back</button>
			</div>
		</div>
	</div>
</template>
<script>

	import Locks from "../services/Locks";

	export default {

		props: ['token', 'lock'],

		data: () => { return {
			isLoading: false,
			activity: null,
		}},

		mounted() {
			this.refresh();
		},

		methods: {
			async refresh() {
				this.isLoading = true;

				let lock = await Locks.find(this.lock.id, this.token);
				this.activity = lock.activity;

				this.isLoading = false;
			},

			back() {
				this.$emit('close');
			}
		}

	}

</script>