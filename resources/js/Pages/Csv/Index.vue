<template>
	<AppLayout title="Csv">
<!-- Render success message -->
<div v-if="successMessage" class="text-green-500 mt-2">
    {{ successMessage }}
  </div>
		<template #header>
			<h2 class="flex justify-between text-xl font-semibold leading-tight text-gray-800">
				<p>
                    Csv
				</p>

                <div>
                    <label for="csv-upload" class="cursor-pointer">
						<span class="px-4 py-2 mr-3 text-sm text-green-600 transition border border-green-300 rounded-full hover:bg-green-600 hover:text-white hover:border-transparent">
						Upload Csv
						</span>
						<input
						type="file"
						accept="csv"
						id="csv-upload"
						style="display: none"
						@change="handleCsvUpload"
						/>
					</label>
                </div>
			</h2>
		</template>

		<div class="py-12">

			<div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
				<div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
					<table class="min-w-full divide-y divide-gray-200">
						<thead class="bg-gray-50">
							<tr>
								<th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									Time
								</th>
								<th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									File Name
								</th>
								<th scope="col"
									class="px-6 py-3 text-xs font-medium tracking-wider text-center text-gray-500 uppercase">
									Status
								</th>
							</tr>
						</thead>
						<tbody class="bg-white divide-y divide-gray-200">
							<tr v-for="csv in csvs" :key="csv.id">
								<td class="px-6 py-4 whitespace-nowrap">
									<div class="text-sm text-center text-gray-900">
										{{ csv.created_at }}
									</div>
								</td>
								<td class="px-6 py-4 whitespace-nowrap">
									<div class="flex items-center justify-center">
										<div class="ml-4">
											<div class="text-sm font-medium text-gray-900">
                                                {{ csv.file_name }}
											</div>
										</div>
									</div>
								</td>
								<td class="px-6 py-4 whitespace-nowrap">
									<div class="flex items-center justify-center">
										<div class="ml-4">
											<div class="text-sm font-medium text-gray-900">
                                                {{ csv.status }}
											</div>
										</div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</AppLayout>
</template>

<script>
import Pagination from '@/Components/Pagination.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
export default {
	components: {
		AppLayout,
		Pagination
	},
	props: {
        csvs: Object,
		successMessage: String  // Add successMessage as a prop
	},
	data() {
		return {
		}
	},
	methods: {
		handleCsvUpload(event) {
			const file = event.target.files[0];
			if (file) {
				const formData = new FormData();
				formData.append('csv_file', file);

				// Adjust the route accordingly for your application
				this.$inertia.post('csv', formData);
			}
		}
	},
	mounted() {
		// Check if the success message prop is present and reload the page
		if (this.successMessage) {
			// Display the success message
			console.log('Success message:', this.successMessage);

			// Reload the page after a brief delay to show the message
			setTimeout(() => {
				window.location.reload();
			}, 3000);  // Adjust the delay time as needed
		}
	}
}
</script>
