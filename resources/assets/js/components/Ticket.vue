<template>
<div>
vue.js component {{ message }}
</div>
<!-- 	<table class="table">
		<thead>
			<tr>
				<th>#</th>
				<th>Subject</th>
				<th>created_at</th>
				<th>updated_at</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="ticket in tickets">
				<td>{{ ticket.id }}</td>
				<td>{{ ticket.subject }}</td>
				<td>{{ ticket.created_at }}</td>
				<td>{{ ticket.updated_at }}</td>
			</tr>
		</tbody>
	</table> -->
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        props: ['message']
    }
</script>
